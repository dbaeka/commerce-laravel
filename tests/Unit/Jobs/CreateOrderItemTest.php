<?php

namespace Tests\Unit\Jobs;

use App\Exceptions\ApiRequestException;
use App\Jobs\CreateOrderItem;
use App\Services\OrderItemServiceInterface;
use Illuminate\Bus\DatabaseBatchRepository;
use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateOrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_order_item_runs()
    {
        $fake = Bus::fake();

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createOrderItem')
                ->once()
                ->andReturn("test_id");
        });

        $pendingBatch = $fake->batch([
            $job = new CreateOrderItem([]),
        ]);

        $pendingBatch->dispatch();

        $fake->assertBatched(function (PendingBatch $pendingBatch) {
            $this->assertCount(1, $pendingBatch->jobs);
            $this->assertInstanceOf(CreateOrderItem::class, $pendingBatch->jobs->first());

            return true;
        });

        $service = app(OrderItemServiceInterface::class);

        $batch = app(DatabaseBatchRepository::class)->store($pendingBatch);
        $job->withBatchId($batch->id)->handle($service);
    }


    public function test_it_cancels_batch_if_order_item_fails()
    {
        $this->expectException(ApiRequestException::class);

        $fake = Bus::fake();

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createOrderItem')
                ->once()
                ->andReturnNull();
        });

        $pendingBatch = $fake->batch([
            $job = new CreateOrderItem([]),
        ]);

        $pendingBatch->dispatch();

        $fake->assertBatched(function (PendingBatch $pendingBatch) {
            $this->assertCount(1, $pendingBatch->jobs);
            $this->assertInstanceOf(CreateOrderItem::class, $pendingBatch->jobs->first());

            return true;
        });

        $service = app(OrderItemServiceInterface::class);

        $batch = app(DatabaseBatchRepository::class)->store($pendingBatch);
        $job->withBatchId($batch->id)->handle($service);

        $batch = app(DatabaseBatchRepository::class)->find($batch->id);
        $this->assertTrue($batch->canceled());
    }
}

<?php

namespace Tests\Unit\Jobs;

use App\Jobs\DeleteOrder;
use App\Jobs\DeleteOrderItem;
use App\Jobs\DeleteOrderItems;
use App\Services\OrderItemServiceInterface;
use App\Services\OrderServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DeleteOrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_order_item_runs_successfully()
    {
        Bus::fake();

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteOrderItem')
                ->once()
                ->andReturn(true);
        });

        $service = app(OrderItemServiceInterface::class);

        (new DeleteOrderItem('sample_id'))->handle($service);

        Bus::assertNothingDispatched();
    }

    public function test_it_retries_delete_order_item_if_failed_delete()
    {
        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteOrderItem')
                ->once()
                ->andReturn(false);
        });

        $job = Mockery::mock(DeleteOrderItem::class, ['sample_id'])->makePartial();

        $service = app(OrderItemServiceInterface::class);

        $job->handle($service);
        $job->shouldHaveReceived('release');
    }
}

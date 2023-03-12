<?php

namespace Tests\Unit\Jobs;

use App\Jobs\DeleteOrder;
use App\Services\OrderServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_order_runs_successfully()
    {
        Bus::fake();

        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteOrder')
                ->once()
                ->andReturn(true);
        });

        $service = app(OrderServiceInterface::class);

        (new DeleteOrder('sample_id'))->handle($service);

        Bus::assertNothingDispatched();
    }

    public function test_it_retries_delete_order_if_failed_delete()
    {
        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteOrder')
                ->once()
                ->andReturn(false);
        });

        $job = Mockery::mock(DeleteOrder::class, ['sample_id'])->makePartial();

        $service = app(OrderServiceInterface::class);

        $job->handle($service);
        $job->shouldHaveReceived('release');
    }
}

<?php

namespace Tests\Unit\Jobs;

use App\DTO\OrderItemDTO;
use App\Jobs\DeleteOrderItem;
use App\Jobs\DeleteOrderItems;
use App\Services\OrderItemServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DeleteOrderItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_order_items_runs_dispatches_delete_order_item_job()
    {
        Bus::fake();

        $orderItemDTO = new OrderItemDTO(
            external_id: "sample_order_item_id",
            name: "test name",
            slug: "test-slug"
        );

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) use ($orderItemDTO) {
            $mock->shouldReceive('getOrderItemsByOrderId')
                ->once()
                ->andReturn([$orderItemDTO, $orderItemDTO]);
        });

        $service = app(OrderItemServiceInterface::class);

        (new DeleteOrderItems('sample_id'))->handle($service);

        Bus::assertDispatchedTimes(DeleteOrderItem::class, 2);
    }

    public function test_it_retries_delete_order_items_if_failed_get_items()
    {
        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getOrderItemsByOrderId')
                ->once()
                ->andReturn(null);
        });

        $job = Mockery::mock(DeleteOrderItems::class, ['sample_id'])->makePartial();

        $service = app(OrderItemServiceInterface::class);

        $job->handle($service);
        $job->shouldHaveReceived('release');
    }
}

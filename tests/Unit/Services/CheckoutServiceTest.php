<?php

namespace Tests\Unit\Services;

use App\DTO\OrderDTO;
use App\Jobs\CreateOrderItem;
use App\Jobs\DeleteOrder;
use App\Jobs\DeleteOrderItems;
use App\Services\CheckoutServiceInterface;
use App\Services\OrderItemServiceInterface;
use App\Services\OrderServiceInterface;
use Exception;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
use Mockery\MockInterface;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    public function test_it_creates_checkout_returns_order_id()
    {
        $orderDTO = new OrderDTO(
            external_id: 'test_id',
            name: 'test order',
            slug: 'test-slug'
        );

        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) use ($orderDTO) {
            $mock->shouldReceive('createOrder')
                ->once()
                ->andReturn($orderDTO);
        });

        $expected_order_id = 'test_id';

        Bus::fake();

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        $order_id = app(CheckoutServiceInterface::class)->createCheckout($data);

        $this->assertEquals($expected_order_id, $order_id);
    }

    public function test_it_schedules_create_order_item_job_when_order_successful()
    {
        $orderDTO = new OrderDTO(
            external_id: 'test_id',
            name: 'test order',
            slug: 'test-slug'
        );

        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) use ($orderDTO) {
            $mock->shouldReceive('createOrder')
                ->once()
                ->andReturn($orderDTO);
        });

        $fake = Bus::fake();

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        app(CheckoutServiceInterface::class)->createCheckout($data);

        $fake->assertBatched(function (PendingBatch $pendingBatch) {
            $this->assertCount(1, $pendingBatch->jobs);
            $this->assertInstanceOf(CreateOrderItem::class, $pendingBatch->jobs[0]);
            return true;
        });

        $fake->assertNotDispatched(DeleteOrderItems::class);
        $fake->assertNotDispatched(DeleteOrder::class);
    }

    public function test_it_schedules_delete_order_when_batch_failed_dispatch_from_exception()
    {
        $orderDTO = new OrderDTO(
            external_id: 'test_id',
            name: 'test order',
            slug: 'test-slug'
        );

        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) use ($orderDTO) {
            $mock->shouldReceive('createOrder')
                ->once()
                ->andReturn($orderDTO);
        });

        Bus::fake();

        Bus::partialMock()
            ->shouldReceive('batch->then->catch->dispatch')
            ->withNoArgs()
            ->once()
            ->andThrow(new Exception());

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        app(CheckoutServiceInterface::class)->createCheckout($data);

        Bus::assertNothingBatched();
        Bus::assertDispatched(DeleteOrder::class);
    }

    public function test_it_schedules_chained_delete_jobs_when_batch_cancelled()
    {
        $orderDTO = new OrderDTO(
            external_id: 'test_id',
            name: 'test order',
            slug: 'test-slug'
        );

        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) use ($orderDTO) {
            $mock->shouldReceive('createOrder')
                ->once()
                ->andReturn($orderDTO);
        });

        $fake = Bus::fake();

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        app(CheckoutServiceInterface::class)->createCheckout($data);

        $fake->assertBatched(function (PendingBatch $pendingBatch) {
            $this->assertCount(1, $pendingBatch->jobs);
            $this->assertInstanceOf(CreateOrderItem::class, $pendingBatch->jobs[0]);

            [$rollback] = $pendingBatch->catchCallbacks();

            $rollback->getClosure()->call($this);

            return true;
        });

        Bus::assertChained([DeleteOrder::class, DeleteOrderItems::class]);
    }

    public function test_it_fails_create_checkout_if_create_order_fails_returns_null()
    {
        $this->mock(OrderServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createOrder')
                ->once()
                ->andReturn(null);
        });

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createOrderItem')
                ->never();
        });

        $order_id = app(CheckoutServiceInterface::class)->createCheckout([]);

        $this->assertNull($order_id);
    }

    public function test_it_gets_default_config()
    {
        $expectedConfig = [
            'shipping_cost' => 10,
            'max_quantity' => 100,
            'base_currency' => 'GHS',
        ];

        config([
            'services.ycode.default_currency' => $expectedConfig['base_currency'],
            'services.ycode.default_max_quantity' => $expectedConfig['max_quantity'],
            'services.ycode.default_shipping_cost' => $expectedConfig['shipping_cost']
        ]);

        $config = app(CheckoutServiceInterface::class)->defaultConfig();

        $this->assertNotNull($config);
        $this->assertEquals($config, (object)$expectedConfig);
    }
}

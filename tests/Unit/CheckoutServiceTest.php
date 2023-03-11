<?php

namespace Tests\Unit;

use App\DTO\OrderDTO;
use App\Services\CheckoutServiceInterface;
use App\Services\OrderItemServiceInterface;
use App\Services\OrderServiceInterface;
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

        $expected_order_id = "sample_order_id";
        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) use ($expected_order_id) {
            $mock->shouldReceive('createOrderItem')
                ->once()
                ->andReturn($expected_order_id);
        });

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        $order_id = app(CheckoutServiceInterface::class)->createCheckout($data);

        $this->assertEquals($expected_order_id, $order_id);
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

    public function test_it_fails_create_checkout_if_create_order_item_fails_returns_null()
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

        $this->mock(OrderItemServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createOrderItem')
                ->once()
                ->andReturn(null);
        });

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        $order_id = app(CheckoutServiceInterface::class)->createCheckout($data);

        $this->assertNull($order_id);
    }

    public function test_it_gets_default_config()
    {
        $expectedConfig = [
            'shipping_cost' => 10,
            'max_quantity' => 100,
            'base_currency' => "GHS",
        ];

        config([
            'services.ycode.default_currency' => $expectedConfig["base_currency"],
            'services.ycode.default_max_quantity' => $expectedConfig["max_quantity"],
            'services.ycode.default_shipping_cost' => $expectedConfig["shipping_cost"]
        ]);

        $config = app(CheckoutServiceInterface::class)->defaultConfig();

        $this->assertNotNull($config);
        $this->assertEquals($config, (object)$expectedConfig);
    }

}

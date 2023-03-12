<?php

namespace Tests\Unit\Services;

use App\DTO\OrderItemDTO;
use App\Services\OrderItemServiceInterface;
use Illuminate\Support\Facades\Http;

class OrderItemServiceTest extends YcodeServiceTestCase
{
    protected string $collection_id = 'order_items_id';

    public function test_it_creates_order_item_returns_order_id()
    {
        $body = file_get_contents(base_path('tests/Fixtures/Services/CreateOrderItemSampleResponse.json'));

        Http::fake([
            "$this->domain/*" => Http::response($body, 200),
        ]);

        $items = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $items = json_decode($items, true)['order']['items'];
        $data = [
            'order_item' => $items[0],
            'order_external_id' => 'testing',
            'order_slug' => 'test-slug'
        ];
        $order_id = app(OrderItemServiceInterface::class)->createOrderItem($data);

        $this->assertStringContainsString($data['order_slug'], $order_id);
    }

    public function test_it_fails_create_order_item_returns_null()
    {
        $items = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $items = json_decode($items, true)['order']['items'];
        $data = [
            'order_item' => $items[0],
            'order_external_id' => 'testing',
            'order_slug' => 'test-slug'
        ];

        Http::fake([
            "{$this->domain}/*" => Http::response(null, 400),
        ]);

        $order_id = app(OrderItemServiceInterface::class)->createOrderItem($data);
        $this->assertNull($order_id);
    }

    public function test_it_gets_order_items_from_order_id_returns_array_order_item_dto()
    {
        $body = file_get_contents(base_path('tests/Fixtures/Services/GetOrderItemSampleResponse.json'));

        Http::fake([
            "$this->domain/*" => Http::response($body, 200),
        ]);

        $orderItemDTOs = app(OrderItemServiceInterface::class)->getOrderItemsByOrderId("sample_id");

        $this->assertCount(2, $orderItemDTOs);

        $this->assertInstanceOf(
            OrderItemDTO::class,
            $orderItemDTOs[0]
        );
    }

    public function test_it_fails_get_order_items_from_order_id_returns_null()
    {

        Http::fake([
            "$this->domain/*" => Http::response(null, 400),
        ]);

        $orderItemDTOs = app(OrderItemServiceInterface::class)->getOrderItemsByOrderId("sample_id");

        $this->assertNull( $orderItemDTOs);
    }


    public function test_it_deletes_order_item_returns_true()
    {
        $response = ["deleted" => 1];

        Http::fake([
            "$this->domain/*" => Http::response($response, 200),
        ]);

        $success = app(OrderItemServiceInterface::class)->deleteOrderItem("sample_id");

        $this->assertTrue($success);
    }

    public function test_it_fails_delete_order_item_returns_false()
    {
        Http::fake([
            "$this->domain/*" => Http::response(null, 400),
        ]);

        $success = app(OrderItemServiceInterface::class)->deleteOrderItem("sample_id");
        $this->assertFalse($success);

        $response = ["deleted" => 0];
        Http::fake([
            "$this->domain/*" => Http::response($response, 200),
        ]);

        $success = app(OrderItemServiceInterface::class)->deleteOrderItem("sample_id");
        $this->assertFalse($success);
    }



    public function test_it_cant_create_order_item_if_base_url_not_provided()
    {
        $this->setup_base_url_not_provided();
        app(OrderItemServiceInterface::class)->createOrderItem([]);
    }

    public function test_it_cant_create_order_item_if_token_not_provided()
    {
        $this->setup_token_not_provided();
        app(OrderItemServiceInterface::class)->createOrderItem([]);
    }

    public function test_it_cant_create_order_item_if_order_items_id_not_provided()
    {
        $this->setup_collection_id_not_provided();
        app(OrderItemServiceInterface::class)->createOrderItem([]);
    }
}

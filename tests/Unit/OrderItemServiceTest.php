<?php

namespace Tests\Unit;

use App\Services\OrderItemServiceInterface;
use Illuminate\Support\Facades\Http;

class OrderItemServiceTest extends YcodeServiceTestCase
{
    protected string $collection_id = "order_items_id";

    public function test_it_creates_order_item_returns_order_id()
    {
        $body = file_get_contents(base_path('tests/Fixtures/Services/CreateOrderItemSampleResponse.json'));

        Http::fake([
            "$this->domain/*" => Http::response($body, 200),
        ]);

        $items = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $items = json_decode($items, true)["order"]["items"];
        $data = [
            "order_items" => $items,
            "order_external_id" => "testing",
            "order_slug" => "test-slug"
        ];
        $order_id = app(OrderItemServiceInterface::class)->createOrderItem($data);

        $this->assertStringContainsString($data["order_slug"], $order_id);
    }

    public function test_it_fails_create_order_item_returns_null()
    {
        $items = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $items = json_decode($items, true)["order"]["items"];
        $data = [
            "order_items" => $items,
            "order_external_id" => "testing",
            "order_slug" => "test-slug"
        ];

        Http::fake([
            "{$this->domain}/*" => Http::response(null, 400),
        ]);

        $order_id = app(OrderItemServiceInterface::class)->createOrderItem($data);
        $this->assertNull($order_id);
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

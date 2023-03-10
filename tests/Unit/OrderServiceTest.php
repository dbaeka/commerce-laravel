<?php

namespace Tests\Unit;

use App\DTO\OrderDTO;
use App\Services\OrderServiceInterface;
use Illuminate\Support\Facades\Http;

class OrderServiceTest extends YcodeServiceTestCase
{
    protected string $collection_id = "orders_id";

    public function test_it_creates_order_returns_order_dto()
    {
        $response = file_get_contents(base_path('tests/Fixtures/Services/CreateOrderSampleResponse.json'));

        Http::fake([
            "$this->domain/*" => Http::response($response, 200),
        ]);

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        $orderDTO = app(OrderServiceInterface::class)->createOrder($data);

        $this->assertInstanceOf(OrderDTO::class, $orderDTO);
    }

    public function test_it_fails_create_order_returns_null()
    {
        Http::fake([
            "{$this->domain}/*" => Http::response(null, 400),
        ]);

        $data = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $data = json_decode($data, true);

        $orderDTO = app(OrderServiceInterface::class)->createOrder($data);
        $this->assertNull($orderDTO);
    }


    public function test_it_cant_create_order_if_base_url_not_provided()
    {
        $this->setup_base_url_not_provided();
        app(OrderServiceInterface::class)->createOrder([]);
    }

    public function test_it_cant_create_order_if_token_not_provided()
    {
        $this->setup_token_not_provided();
        app(OrderServiceInterface::class)->createOrder([]);
    }

    public function test_it_cant_create_order_if_orders_id_not_provided()
    {
        $this->setup_collection_id_not_provided();
        app(OrderServiceInterface::class)->createOrder([]);
    }
}

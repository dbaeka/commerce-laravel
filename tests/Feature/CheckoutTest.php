<?php

namespace Tests\Feature;

use App\Services\CheckoutServiceInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    public function test_successfully_create_checkout(): void
    {
        $params = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $params = json_decode($params, true);
        $this->mock(CheckoutServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('createCheckout')
                ->once()
                ->andReturn('sample_order_id');
        });

        $response = $this->postJson('/create-checkout', $params);

        $response->assertStatus(200);
    }

    public function test_successfully_gets_default_config(): void
    {
        $config = [
            'shipping_cost' => 10,
            'max_quantity' => 100,
            'base_currency' => 'GHS',
        ];
        $this->mock(CheckoutServiceInterface::class, function (MockInterface $mock) use ($config) {
            $mock->shouldReceive('defaultConfig')
                ->once()
                ->andReturn((object)$config);
        });

        $response = $this->getJson('/get-default-config');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => array_keys($config),
            'success'
        ]);
        $response->assertJsonFragment([
            $config
        ]);
    }


    public function test_fails_create_checkout_when_wrong_parameter()
    {
        $response = $this->postJson('/create-checkout');

        $error_keys = [
            'contact',
            'contact.email',
            'shipping',
            'shipping.first_name',
            'shipping.last_name',
            'shipping.address',
            'shipping.city',
            'shipping.country',
            'shipping.state_province',
            'shipping.postal_code',
            'shipping.phone',
            'order',
            'order.name',
            'order.items',
            'order.shipping_cost',
            'order.sub_total',
            'order.total',
        ];

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors',
            'success'
        ]);

        $response->assertJsonFragment([
            'success' => false
        ]);

        $response->assertJsonValidationErrors($error_keys);
    }

    public function test_fails_create_checkout_when_order_items_invalid()
    {
        $params = file_get_contents(base_path('tests/Fixtures/Services/SampleCheckoutData.json'));
        $params = json_decode($params, true);

        $params['order']['items'] = [[]];

        $response = $this->postJson('/create-checkout', $params);

        $error_keys = [
            'order.items.0.name',
            'order.items.0.slug',
            'order.items.0.product_id',
            'order.items.0.quantity'
        ];

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors',
            'success'
        ]);

        $response->assertJsonFragment([
            'success' => false
        ]);

        $response->assertJsonValidationErrors($error_keys);
    }
}

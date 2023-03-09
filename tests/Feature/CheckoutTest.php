<?php

namespace Tests\Feature;

use Tests\TestCase;

class CheckoutTest extends TestCase
{

    public function test_create_checkout(): void
    {
        $params = [

        ];

        $response = $this->postJson('/create-checkout', $params);

        $response->assertStatus(200);
    }

    public function test_error_create_checkout_when_wrong_parameter()
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
            'errors'
        ]);

        $response->assertJsonValidationErrors($error_keys);
    }
}

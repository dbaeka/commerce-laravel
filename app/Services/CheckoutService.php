<?php

namespace App\Services;

use App\Exceptions\MissingEnvVariableException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutService implements CheckoutServiceInterface
{
    public function createCheckout(array $data): ?string
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $order_id = $this->getOrdersId();
        $order_items_id = $this->getOrderItemsId();
        try {
            $create_order_endpoint = "collections/$order_id/items";
            $order_data = $data["order"];
            $shipping_data = $data["shipping"];
            $contact_data = $data["contact"];
            $response = $request->post($create_order_endpoint, [
                "Subtotal" => $order_data["sub_total"],
                "Shipping" => $order_data["shipping_cost"],
                "Customer name" => $shipping_data["first_name"] . " " . $shipping_data["last_name"],
                "Name" => "Order - " . $order_data["name"],
                "Slug" => Str::slug("order {$order_data["name"]}"),
                "Email" => $contact_data["email"],
                "Phone" => $shipping_data["phone"],
                "Address line 1" => $shipping_data["address"],
                "Address line 2" => $shipping_data["apartment_suite"],
                "City" => $shipping_data["city"],
                "Country" => $shipping_data["country"],
                "State" => $shipping_data["state_province"],
                "ZIP" => $shipping_data["postal_code"],
                "Total" => $order_data["total"]
            ]);
            $response->throw();
            $order_external_id = $response->json("_ycode_id");
            $order_slug = $response->json("Slug");
            $create_order_items_endpoint = "collections/$order_items_id/items";
            foreach ($order_data["items"] as $order_item) {
                $response = $request->post($create_order_items_endpoint, [
                    "Product" => $order_item["product_id"],
                    "Quantity" => $order_item["quantity"],
                    "Order" => $order_external_id,
                    "Name" => "Order items {$order_item["name"]}",
                    "Slug" => Str::slug("order items {$order_item["slug"]} $order_slug")
                ]);
                $response->throw();
            }

            return $order_slug;
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage(), [
                $e,
            ]);
        }
        return null;
    }

    /**
     * Make sure that env variables are set.
     *
     * @return void
     */
    private function validateEnvVariables(): void
    {
        if (!config('services.ycode') || empty(config('services.ycode.token'))
            || empty(config('services.ycode.base_url'))) {
            throw new MissingEnvVariableException();
        }
    }

    private function getBaseRequest(): PendingRequest
    {
        $token = config("services.ycode.token");
        $base_url = config("services.ycode.base_url");
        return Http::withToken($token)->acceptJson()->baseUrl($base_url)->timeout(30);
    }

    private function getCollectionId()
    {
        if (empty(config('services.ycode.collections.products_id'))) {
            throw new MissingEnvVariableException();
        }
        return config('services.ycode.collections.products_id');
    }

    private function getOrdersId()
    {
        if (empty(config('services.ycode.collections.orders_id'))) {
            throw new MissingEnvVariableException();
        }
        return config('services.ycode.collections.orders_id');
    }

    private function getOrderItemsId()
    {
        if (empty(config('services.ycode.collections.order_items_id'))) {
            throw new MissingEnvVariableException();
        }
        return config('services.ycode.collections.order_items_id');
    }
}

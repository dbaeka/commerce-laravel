<?php

namespace App\Services;

use App\DTO\OrderDTO;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService extends BaseYcodeService implements OrderServiceInterface
{
    protected string $collection_id = "orders_id";

    public function createOrder(array $data): ?OrderDTO
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $order_id = $this->getCollectionId();
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
            $response = $response->json();
            return new OrderDTO(
                external_id: $response["_ycode_id"],
                name: $response["Name"],
                slug: $response["Slug"]
            );
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage(), [
                $e,
            ]);
        }
        return null;
    }
}

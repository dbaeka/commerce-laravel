<?php

namespace App\Services;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderItemService extends BaseYcodeService implements OrderItemServiceInterface
{
    protected string $collection_id = "order_items_id";

    public function createOrderItem(array $data): ?string
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $order_items_id = $this->getCollectionId();
        try {
            $order_items = $data["order_items"];
            $order_external_id = $data["order_external_id"];
            $order_slug = $data["order_slug"];
            $create_order_items_endpoint = "collections/$order_items_id/items";
            foreach ($order_items as $order_item) {
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
}

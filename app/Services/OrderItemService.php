<?php

namespace App\Services;

use App\DTO\OrderItemDTO;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderItemService extends BaseYcodeService implements OrderItemServiceInterface
{
    protected string $collection_id = 'order_items_id';

    public function createOrderItem(array $data): ?string
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $order_items_id = $this->getCollectionId();
        try {
            $order_external_id = $data['order_external_id'];
            $order_slug = $data['order_slug'];
            $order_item = $data['order_item'];
            $create_order_items_endpoint = "collections/$order_items_id/items";

            $response = $request->post($create_order_items_endpoint, [
                'Product' => $order_item['product_id'],
                'Quantity' => $order_item['quantity'],
                'Order' => $order_external_id,
                'Name' => "Order items {$order_item['name']}",
                'Slug' => Str::slug("order items {$order_item['slug']} $order_slug")
            ]);
            $response->throw();
            return $order_slug;
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage());
        }
        return null;
    }

    public function getOrderItemsByOrderId(string $order_id): ?array
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $collection_id = $this->getCollectionId();
        try {
            $get_order_item_endpoint = "collections/$collection_id/items?filter[Order]=$order_id";
            $response = $request->get($get_order_item_endpoint);
            $response->throw();
            $items = $response->json('data');
            $orderItemDTOs = [];
            foreach ($items as $item) {
                $orderItemDTOs[] = new OrderItemDTO(
                    external_id: $item['_ycode_id'],
                    name: $item['Name'],
                    slug: $item['Slug'],
                );
            }
            return $orderItemDTOs;
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage());
        }
        return null;
    }

    public function deleteOrderItem(string $order_item_id): bool
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $collection_id = $this->getCollectionId();
        try {
            $delete_order_item_endpoint = "collections/$collection_id/items/$order_item_id";
            $response = $request->delete($delete_order_item_endpoint);
            $response->throw();
            $response = $response->json();
            if ($response["deleted"]) {
                return true;
            }
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage());
        }
        return false;
    }
}

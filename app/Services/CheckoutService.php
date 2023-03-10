<?php

namespace App\Services;

class CheckoutService implements CheckoutServiceInterface
{

    public function __construct(
        private readonly OrderServiceInterface     $order_service,
        private readonly OrderItemServiceInterface $order_item_service)
    {
    }

    public function createCheckout(array $data): ?string
    {
        $order = $this->order_service->createOrder($data);
        if (!empty($order)) {
            return $this->order_item_service->createOrderItem([
                "order_items" => $data["order"]["items"],
                "order_external_id" => $order->external_id,
                "order_slug" => $order->slug
            ]);
        }
        return null;
    }
}

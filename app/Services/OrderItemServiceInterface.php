<?php

namespace App\Services;

interface OrderItemServiceInterface
{
    public function createOrderItem(array $data): ?string;

    public function getOrderItemsByOrderId(string $order_id): ?array;

    public function deleteOrderItem(string $order_item_id): bool;
}

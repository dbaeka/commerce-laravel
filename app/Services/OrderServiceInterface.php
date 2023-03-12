<?php

namespace App\Services;

use App\DTO\OrderDTO;

interface OrderServiceInterface
{
    public function createOrder(array $data): ?OrderDTO;

    public function deleteOrder(string $order_id): bool;
}

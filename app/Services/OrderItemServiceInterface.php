<?php

namespace App\Services;

interface OrderItemServiceInterface
{
    public function createOrderItem(array $data): ?string;
}

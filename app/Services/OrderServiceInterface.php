<?php

namespace App\Services;

use App\DTO\OrderDTO;

interface OrderServiceInterface
{
    public function createOrder(array $data): ?OrderDTO;
}

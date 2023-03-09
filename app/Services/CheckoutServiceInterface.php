<?php

namespace App\Services;

interface CheckoutServiceInterface
{
    public function createCheckout(array $data): ?string;
}

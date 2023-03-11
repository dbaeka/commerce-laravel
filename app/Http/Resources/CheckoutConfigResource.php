<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shipping_cost' => $this->shipping_cost,
            'max_quantity' => $this->max_quantity,
            'base_currency' => $this->base_currency,
        ];
    }
}

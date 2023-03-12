<?php

namespace App\DTO;

class OrderItemDTO
{
    public function __construct(
        public string $external_id,
        public string $name,
        public string $slug,
    )
    {
    }
}

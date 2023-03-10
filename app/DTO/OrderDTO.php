<?php

namespace App\DTO;

class OrderDTO
{
    public function __construct(
        public string $external_id,
        public string $name,
        public string $slug,
    )
    {
    }
}

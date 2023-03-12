<?php

namespace App\DTO;

class ProductDTO
{
    public function __construct(
        public string $external_id,
        public string $name,
        public string $price,
        public string $slug,
        public string $image_url,
        public string $color
    ) {
    }
}

<?php

namespace Tests\Feature;

use App\DTO\ProductDTO;
use App\Services\ProductServiceInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected array $jsonProduct = [
        'external_id',
        'name',
        'price',
        'slug',
        'image_url',
    ];

    public function test_get_products(): void
    {
        $productDTOs = [
            new ProductDTO(
                external_id: 1,
                name: 'Product 1',
                price: 10.00,
                slug: 'Description 1',
                image_url: "https://example.com/1",
                color: "black"
            ),
            new ProductDTO(
                external_id: 2,
                name: 'Product 2',
                price: 30.00,
                slug: 'Description 1',
                image_url: "https://example.com/2",
                color: "gray"
            ),
        ];
        $this->mock(ProductServiceInterface::class, function (MockInterface $mock) use ($productDTOs) {
            $mock->shouldReceive('getProducts')
                ->once()
                ->andReturn($productDTOs);
        });

        $response = $this->get('/get-products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => $this->jsonProduct],
        ]);
        $response->assertJsonFragment([
            'external_id' => '2',
            'name' => 'Product 2',
            'price' => '30',
        ]);
    }
}

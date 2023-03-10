<?php

namespace Tests\Unit;

use App\DTO\ProductDTO;
use App\Services\ProductServiceInterface;
use Illuminate\Support\Facades\Http;

class ProductServiceTest extends YcodeServiceTestCase
{
    protected string $collection_id = "products_id";

    public function test_it_gets_products_returns_product_dto()
    {
        $body = file_get_contents(base_path('tests/Fixtures/Services/GetProductsSampleResponse.json'));

        Http::fake([
            "$this->domain/*" => Http::response($body, 200),
        ]);

        $productDTOs = app(ProductServiceInterface::class)->getProducts();

        $this->assertCount(2, $productDTOs);

        $this->assertInstanceOf(
            ProductDTO::class,
            $productDTOs[0]
        );
    }

    public function test_it_fails_get_products_returns_null()
    {
        Http::fake([
            "{$this->domain}/*" => Http::response(null, 400),
        ]);

        $productDTOs = app(ProductServiceInterface::class)->getProducts();
        $this->assertNull($productDTOs);
    }

    public function test_it_cant_get_products_if_base_url_not_provided()
    {
        $this->setup_base_url_not_provided();
        app(ProductServiceInterface::class)->getProducts();
    }

    public function test_it_cant_get_products_if_token_not_provided()
    {
        $this->setup_token_not_provided();
        app(ProductServiceInterface::class)->getProducts();
    }

    public function test_it_cant_get_products_if_products_id_not_provided()
    {
        $this->setup_collection_id_not_provided();
        app(ProductServiceInterface::class)->getProducts();
    }
}

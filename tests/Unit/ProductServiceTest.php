<?php

namespace Tests\Unit;

use App\DTO\ProductDTO;
use App\Exceptions\MissingEnvVariableException;
use App\Services\ProductServiceInterface;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private string $domain;

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
        config([
            'services.ycode.base_url' => null
        ]);

        $this->expectException(MissingEnvVariableException::class);

        app(ProductServiceInterface::class)->getProducts();
    }

    public function test_it_cant_get_products_if_token_not_provided()
    {
        config([
            'services.ycode.token' => null
        ]);

        $this->expectException(MissingEnvVariableException::class);

        app(ProductServiceInterface::class)->getProducts();
    }

    public function test_it_cant_get_products_if_products_id_not_provided()
    {
        config([
            'services.ycode.collections.products_id' => null
        ]);

        $this->expectException(MissingEnvVariableException::class);

        app(ProductServiceInterface::class)->getProducts();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setCorrectConfig();
    }

    private function setCorrectConfig(): void
    {
        $base_url = config('services.ycode.base_url');
        config([
            'services.ycode.token' => 'test',
            'services.ycode.base_url' => $base_url,
            'services.ycode.collections.products_id' => 'test'
        ]);

        $this->domain = parse_url($base_url, PHP_URL_HOST);
    }
}

<?php

namespace Tests\Unit\Services;

use App\Exceptions\MissingEnvVariableException;
use App\Services\ProductServiceInterface;
use Tests\TestCase;

class YcodeServiceTestCase extends TestCase
{
    protected string $domain;
    protected string $collection_id;

    protected function setup_base_url_not_provided()
    {
        config([
            'services.ycode.base_url' => null
        ]);

        $this->expectException(MissingEnvVariableException::class);
    }

    protected function setup_token_not_provided()
    {
        config([
            'services.ycode.token' => null
        ]);

        $this->expectException(MissingEnvVariableException::class);

        app(ProductServiceInterface::class)->getProducts();
    }

    protected function setup_collection_id_not_provided()
    {
        config([
            'services.ycode.collections.' . $this->collection_id => null
        ]);

        $this->expectException(MissingEnvVariableException::class);
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
            'services.ycode.collections.products_id' => 'test',
            'services.ycode.collections.orders_id' => 'test',
            'services.ycode.collections.order_items_id' => 'test'
        ]);

        $this->domain = parse_url($base_url, PHP_URL_HOST);
    }
}

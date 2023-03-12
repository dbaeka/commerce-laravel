<?php

namespace App\Services;

use App\DTO\ProductDTO;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductService extends BaseYcodeService implements ProductServiceInterface
{
    protected string $collection_id = 'products_id';

    public function getProducts(): ?array
    {
        $products = $this->getProductsFromCache() ?? $this->getProductsFromRemote();
        if (empty($products)) {
            return null;
        }
        $productDTOs = [];
        foreach ($products as $product) {
            $productDTOs[] = new ProductDTO(
                external_id: $product['_ycode_id'],
                name: $product['Name'],
                price: $product['Price'],
                slug: $product['Slug'],
                image_url: $product['Image'],
                color: $product['Color']
            );
        }
        return $productDTOs;
    }

    private function getProductsFromCache(): ?array
    {
        $products = Cache::get('products_list');
        if (!empty($products)) {
            return json_decode($products, true);
        }
        return null;
    }

    private function getProductsFromRemote(): ?array
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $collection_id = $this->getCollectionId();
        try {
            $response = $request->get("collections/$collection_id/items", []);
            $response->throw();
            $data = $response->json('data');
            // Cache results for 1 minute
            Cache::set('products_list', json_encode($data), 60);
            return $data;
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage(), [
                $e,
            ]);
        }
        return null;
    }
}

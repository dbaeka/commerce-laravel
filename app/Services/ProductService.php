<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Exceptions\MissingEnvVariableException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductService implements ProductServiceInterface
{
    public function getProducts(): ?array
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $collection_id = $this->getCollectionId();
        try {
            $response = $request->get("collections/$collection_id/items", []);
            $response->throw();
            $productDTOs = [];
            if ($response->successful()) {
                foreach ($response->json("data") as $product) {
                    $productDTOs[] = new ProductDTO(
                        external_id: $product["_ycode_id"],
                        name: $product["Name"],
                        price: $product["Price"],
                        slug: $product["Slug"],
                        image_url: $product["Image"],
                        color: $product["Color"]
                    );
                }
                return $productDTOs;
            }
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage(), [
                $e,
            ]);
        }
        return null;
    }

    /**
     * Make sure that env variables are set.
     *
     * @return void
     */
    private function validateEnvVariables(): void
    {
        if (!config('services.ycode') || empty(config('services.ycode.token'))
            || empty(config('services.ycode.base_url'))) {
            throw new MissingEnvVariableException();
        }
    }

    private function getBaseRequest(): PendingRequest
    {
        $token = config("services.ycode.token");
        $base_url = config("services.ycode.base_url");
        return Http::withToken($token)->acceptJson()->baseUrl($base_url)->timeout(30);
    }

    private function getCollectionId()
    {
        if (empty(config('services.ycode.collections.products_id'))) {
            throw new MissingEnvVariableException();
        }
        return config('services.ycode.collections.products_id');
    }
}

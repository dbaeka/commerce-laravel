<?php

namespace App\Services;

use App\DTO\ProductDTO;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;

class ProductService extends BaseYcodeService implements ProductServiceInterface
{
    protected string $collection_id = "products_id";

    public function getProducts(): ?array
    {
        $this->validateEnvVariables();
        $request = $this->getBaseRequest();
        $collection_id = $this->getCollectionId();
        try {
            $response = $request->get("collections/$collection_id/items", []);
            $response->throw();
            $productDTOs = [];
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
        } catch (HttpClientException $e) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage(), [
                $e,
            ]);
        }
        return null;
    }
}

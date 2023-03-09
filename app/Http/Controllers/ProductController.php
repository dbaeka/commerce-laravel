<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request, ProductServiceInterface $productService): AnonymousResourceCollection
    {
        $products = $productService->getProducts();

        return ProductResource::collection($products);
    }
}

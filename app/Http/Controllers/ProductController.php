<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductServiceInterface $productService): ProductCollection
    {
        $products = $productService->getProducts();

        return new ProductCollection($products);
    }
}

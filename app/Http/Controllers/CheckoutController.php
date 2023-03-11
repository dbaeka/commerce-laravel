<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutConfigResource;
use App\Services\CheckoutServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

/**
 * @class CheckoutController
 */
class CheckoutController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('checkout.index');
    }

    public function store(CheckoutRequest $request, CheckoutServiceInterface $service): JsonResponse
    {

        $order = $service->createCheckout($request->all());

        return response()->json([
            "order" => $order,
            "success" => true,
        ]);
    }

    public function defaultConfig(CheckoutServiceInterface $service): CheckoutConfigResource
    {
        $config = $service->defaultConfig();

        return new CheckoutConfigResource($config);
    }
}

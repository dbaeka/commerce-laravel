<?php

namespace App\Providers;

use App\Services\CheckoutService;
use App\Services\CheckoutServiceInterface;
use App\Services\OrderItemService;
use App\Services\OrderItemServiceInterface;
use App\Services\OrderService;
use App\Services\OrderServiceInterface;
use App\Services\ProductService;
use App\Services\ProductServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CheckoutServiceInterface::class, CheckoutService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(OrderItemServiceInterface::class, OrderItemService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

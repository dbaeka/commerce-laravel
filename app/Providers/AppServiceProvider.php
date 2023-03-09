<?php

namespace App\Providers;

use App\Services\CheckoutService;
use App\Services\CheckoutServiceInterface;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

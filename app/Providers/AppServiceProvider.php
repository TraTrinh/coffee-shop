<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;   // ← thêm dòng này
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();   // ← thêm dòng này

        View::composer('layouts.shop', function ($view) {
            $view->with('cartCount', app(CartService::class)->count());
        });
    }
}
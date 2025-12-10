<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count to all views
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->count();
            }
            $view->with('cartCount', $cartCount);
        });
    }
}

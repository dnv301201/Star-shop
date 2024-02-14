<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\User;

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
        Paginator::useBootstrap();
        View::composer('users.partials.header', function ($view) {
            $userCart = Cart::with('products')->where('user_id', auth()->id())->first();
            $cartProducts = $userCart ? $userCart->products : collect();
            $view->with('cartProducts', $cartProducts);
        });

        View::composer('admin.partials.slidebar', function ($view) {
            $adminUser = User::find(auth()->id()); // Đặt lại tên model User nếu cần
            $view->with('adminUser', $adminUser);
        });
    }
}

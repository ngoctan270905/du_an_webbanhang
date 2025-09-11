<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Gắn dữ liệu cho header của client
        View::composer('partials.header', function ($view) {
            $topCategories = Category::withCount('product')
                ->orderByDesc('product_count')
                ->take(5)
                ->get();

            $view->with('topCategories', $topCategories);
        });
    }
}

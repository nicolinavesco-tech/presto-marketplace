<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;

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
        Paginator::useBootstrapFive();
        if (Schema::hasTable('categories')){
            View::share('categories', Category::orderBy('name')->get());
        }
        

        Password::defaults(function () {
            return Password::min(10)->mixedCase()->numbers()->symbols();
        });

        
        if (app()->environment('production')) {
        URL::forceScheme('https');
     }
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Menu;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('home', function($view) 
        {$view->with('menus', Menu::menus());
        });
    }



    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

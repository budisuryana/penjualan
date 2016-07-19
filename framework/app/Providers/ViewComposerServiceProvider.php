<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->createMenu();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Create menu dynamically
     * 
     */
    private function createMenu()
    {
        view()->composer('includes.sidebarmenu', 'App\Http\Composers\NavigationComposer');
    }
}

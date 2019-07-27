<?php

namespace App\Providers;

use App\Flag;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $flags = Flag::whereId(1)->first();
        view()->share('flags', $flags);
    }
}

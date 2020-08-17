<?php

namespace App\Providers;

use App\Model\SyntheticModel;
use App\Observers\SyntheticObserver;
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
        //
        SyntheticModel::observe(SyntheticObserver::class);
    }
}

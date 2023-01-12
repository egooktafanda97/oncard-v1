<?php

namespace App\Providers;

use App\Service\Control\ManagementCrud;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Traits\ManagementProvider;



class AppServiceProvider extends ServiceProvider
{
    use ManagementProvider;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set('Asia/Jakarta');
    }
}

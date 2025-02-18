<?php

namespace App\Providers;

use Exception;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
	Paginator::useBootstrap();

    Paginator::useBootstrap();

        try {
            $dbconnect = DB::connection()->getPDO();
            $dbname = DB::connection()->getDatabaseName();
            $settings = Setting::first();
            config([
    'settings' => $settings
            ]);
         } catch(Exception $e) {

         }
    }
}

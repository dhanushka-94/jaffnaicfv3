<?php

namespace App\Providers;

use App\Models\ApplicationSetting;
use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Share site settings and application settings with all views
        View::composer('*', function ($view) {
            try {
                // Check if database connection is available and tables exist
                if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                    $view->with('__site', SiteSetting::first());
                } else {
                    $view->with('__site', null);
                }
                
                if (\Illuminate\Support\Facades\Schema::hasTable('application_settings')) {
                    $view->with('__app', ApplicationSetting::first());
                } else {
                    $view->with('__app', null);
                }
            } catch (\Exception $e) {
                // If database is not available (e.g., during composer install), set to null
                $view->with('__site', null);
                $view->with('__app', null);
            }
        });
    }
}

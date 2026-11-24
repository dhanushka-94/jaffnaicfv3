<?php

namespace App\Providers;

use App\Models\ApplicationSetting;
use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production')) {
            // Always generate https:// links (assets, routes, canonical tags, sitemap).
            URL::forceScheme('https');
        }

        // Public pages: generous per-IP limit that still stops scrapers and floods.
        RateLimiter::for('public', fn (Request $request) => Limit::perMinute(120)->by($request->ip()));

        // The PDF download streams a file and writes a log row, so keep it tighter.
        RateLimiter::for('downloads', fn (Request $request) => Limit::perMinute(20)->by($request->ip()));

        // Share site settings and application settings with all views.
        // Loaded lazily and only once per request (this composer runs for every view/partial).
        $settings = null;

        View::composer('*', function ($view) use (&$settings) {
            if ($settings === null) {
                $settings = ['site' => null, 'app' => null];

                try {
                    $settings['site'] = SiteSetting::query()->first();
                    $settings['app'] = ApplicationSetting::query()->first();
                } catch (\Throwable) {
                    // Database not available or not migrated yet (e.g. during composer install).
                }
            }

            $view->with('__site', $settings['site']);
            $view->with('__app', $settings['app']);
        });
    }
}
<?php

use App\Http\Middleware\EnforceCanonicalUrl;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Plesk serves HTTPS on nginx and proxies to Apache.
        $middleware->trustProxies(at: '*');

        // One canonical scheme + host (production only) and security headers on every response,
        // including the Filament admin panel and Livewire requests.
        $middleware->append([
            EnforceCanonicalUrl::class,
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
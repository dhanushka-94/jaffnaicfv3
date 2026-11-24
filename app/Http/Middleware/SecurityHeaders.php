<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = $response->headers;

        $headers->set('X-Content-Type-Options', 'nosniff');
        $headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()');
        $headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Do not advertise the PHP / hosting stack.
        $headers->remove('X-Powered-By');
        header_remove('X-Powered-By');

        if ($request->isSecure()) {
            $headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $isPanel = $request->is('admin', 'admin/*', 'livewire', 'livewire/*', 'livewire-*');

        if ($isPanel) {
            // The admin panel must never be framed, cached by shared caches, or indexed.
            $headers->set('X-Frame-Options', 'DENY');
            $headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
            $headers->set('Cache-Control', 'no-store, private');

            return $response;
        }

        $headers->set('X-Frame-Options', 'SAMEORIGIN');

        if (! config('seo.indexable')) {
            $headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        // Content-Security-Policy for the public website only (the Filament panel
        // relies on inline scripts / blob: previews that would need a looser policy).
        if (
            ! $response->isRedirection()
            && ! file_exists(public_path('hot')) // Vite dev server needs a looser policy
            && str_contains((string) $headers->get('Content-Type'), 'text/html')
        ) {
            $headers->set('Content-Security-Policy', $this->contentSecurityPolicy($request->isSecure()));
        }

        return $response;
    }

    private function contentSecurityPolicy(bool $secure): string
    {
        return implode('; ', array_filter([
            "default-src 'self'",
            // Alpine.js evaluates x-data / @click expressions, which needs 'unsafe-eval'.
            "script-src 'self' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' data: https://fonts.gstatic.com",
            "img-src 'self' data: blob: https:",
            "connect-src 'self'",
            "media-src 'self'",
            "frame-src https://www.google.com https://maps.google.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            $secure ? 'upgrade-insecure-requests' : null,
        ]));
    }
}
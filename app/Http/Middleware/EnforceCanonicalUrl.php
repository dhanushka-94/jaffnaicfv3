<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sends every visitor to one canonical scheme + host (APP_URL), e.g.
 * http://www.jaffnaicf.lk/about/team -> https://jaffnaicf.lk/about/team
 *
 * Prevents duplicate content (www / non-www / http / https) in search engines.
 */
class EnforceCanonicalUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('seo.enforce_canonical_url') || ! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $canonical = parse_url((string) config('app.url'));

        if (empty($canonical['host']) || empty($canonical['scheme'])) {
            return $next($request);
        }

        $host = strtolower($canonical['host']);
        $scheme = $canonical['scheme'];

        if (strtolower($request->getHost()) !== $host || $request->getScheme() !== $scheme) {
            $port = isset($canonical['port']) ? ':' . $canonical['port'] : '';

            return redirect()->to($scheme . '://' . $host . $port . $request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
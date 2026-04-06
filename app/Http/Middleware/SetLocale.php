<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('localization.supported', []));
        $default = config('localization.default', 'ru');

        $locale = $request->session()->get('locale');
        if (! $locale && $request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
        }
        if ($locale === 'kz') {
            $locale = 'kk';
        }
        if (! in_array($locale, $supported, true)) {
            $locale = $default;
        }

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        return $next($request);
    }
}

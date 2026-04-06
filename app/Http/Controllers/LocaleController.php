<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supported = array_keys(config('localization.supported', []));
        abort_unless(in_array($locale, $supported, true), 404);

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        $minutes = (int) config('localization.cookie_minutes', 525600);

        return redirect()
            ->back(fallback: route('home'))
            ->cookie('locale', $locale, $minutes);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ContributionController extends Controller
{
    public function index(): View
    {
        $contributions = __('contributions');

        $architectureCard = $contributions['architecture_card'] ?? [];
        if (! empty($architectureCard['photo_keys'])) {
            $architectureCard['photos'] = collect($architectureCard['photo_keys'])
                ->map(fn (string $k) => asset('images/contributions/'.$k))
                ->values()
                ->all();
            $contributions['architecture_card'] = $architectureCard;
        }

        return view('contributions.index', compact('contributions'));
    }
}


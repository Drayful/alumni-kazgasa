<?php

namespace App\Http\Controllers;

use App\Models\ArchivePhoto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchiveGalleryController extends Controller
{
    public function index(Request $request): View
    {
        $decade = $request->query('decade');
        if (! is_string($decade) || ! in_array($decade, ArchivePhoto::DECADES, true)) {
            $decade = '90s';
        }

        $archiveDecades = [
            '80s' => __('site.archive_decades.80s'),
            '90s' => __('site.archive_decades.90s'),
            '00s' => __('site.archive_decades.00s'),
            '10s' => __('site.archive_decades.10s'),
            '20s' => __('site.archive_decades.20s'),
        ];

        $photos = ArchivePhoto::query()
            ->where('decade', $decade)
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return view('archive.index', compact('photos', 'decade', 'archiveDecades'));
    }
}

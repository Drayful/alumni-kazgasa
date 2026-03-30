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
            '80s' => '80‑е',
            '90s' => '90‑е',
            '00s' => '00‑е',
            '10s' => '10‑е',
            '20s' => '20‑е',
        ];

        $photos = ArchivePhoto::query()
            ->where('decade', $decade)
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return view('archive.index', compact('photos', 'decade', 'archiveDecades'));
    }
}

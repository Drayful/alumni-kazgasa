<?php

namespace App\Http\Controllers;

use App\Models\ArchivePhoto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function welcome(): View
    {
        $archivePhotos = ArchivePhoto::query()
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->get();

        $archiveDecades = [
            '80s' => '80‑е',
            '90s' => '90‑е',
            '00s' => '00‑е',
            '10s' => '10‑е',
            '20s' => '20‑е',
        ];

        return view('welcome', compact('archivePhotos', 'archiveDecades'));
    }
}

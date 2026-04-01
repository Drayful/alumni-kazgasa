<?php

namespace App\Http\Controllers;

use App\Models\AlumniCardPartner;
use App\Models\ArchivePhoto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function welcome(): View
    {
        $archiveDecades = [
            '80s' => '80‑е',
            '90s' => '90‑е',
            '00s' => '00‑е',
            '10s' => '10‑е',
            '20s' => '20‑е',
        ];

        $limit = ArchivePhoto::HOME_PREVIEW_LIMIT;
        $decadeKeys = array_keys($archiveDecades);

        $archivePhotoTotals = array_fill_keys($decadeKeys, 0);
        $countsByDecade = ArchivePhoto::query()
            ->selectRaw('decade, count(*) as c')
            ->whereIn('decade', $decadeKeys)
            ->groupBy('decade')
            ->pluck('c', 'decade');
        foreach ($countsByDecade as $d => $c) {
            $archivePhotoTotals[$d] = (int) $c;
        }

        $archivePhotosPreview = [];
        foreach ($decadeKeys as $decade) {
            $archivePhotosPreview[$decade] = ArchivePhoto::query()
                ->where('decade', $decade)
                ->with('user:id,name')
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get();
        }

        $cardPartners = AlumniCardPartner::query()->active()->get();

        return view('welcome', compact(
            'archiveDecades',
            'archivePhotosPreview',
            'archivePhotoTotals',
            'cardPartners'
        ));
    }
}

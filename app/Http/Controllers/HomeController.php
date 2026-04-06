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
            '80s' => __('site.archive_decades.80s'),
            '90s' => __('site.archive_decades.90s'),
            '00s' => __('site.archive_decades.00s'),
            '10s' => __('site.archive_decades.10s'),
            '20s' => __('site.archive_decades.20s'),
        ];

        $schedule = $this->welcomeSchedule();

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
            'cardPartners',
            'schedule'
        ));
    }

    /**
     * @return list<array{time: string, start: string, end: string, title: string, place: string}>
     */
    private function welcomeSchedule(): array
    {
        /** @var list<array{title: string, place: string}> $blocks */
        $blocks = __('site.schedule_blocks');
        $times = [
            ['time' => '15:00', 'start' => '15:00', 'end' => '15:30'],
            ['time' => '15:30', 'start' => '15:30', 'end' => '16:30'],
            ['time' => '15:30', 'start' => '15:30', 'end' => '16:30'],
            ['time' => '15:30', 'start' => '15:30', 'end' => '16:30'],
            ['time' => '15:30', 'start' => '15:30', 'end' => '16:30'],
            ['time' => '16:30', 'start' => '16:30', 'end' => '18:00'],
            ['time' => '18:00', 'start' => '18:00', 'end' => '19:00'],
            ['time' => '19:00', 'start' => '19:00', 'end' => '19:30'],
        ];

        return collect($times)->map(fn (array $t, int $i): array => array_merge($t, $blocks[$i]))->all();
    }
}

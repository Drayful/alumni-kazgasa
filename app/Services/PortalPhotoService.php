<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PortalPhotoService
{
    public const CACHE_TTL = 7;
    public const PHOTOS_DIR = 'portal-photos';

    public function getPhotoForAlumni(string $iin): array
    {
        $cacheKey = 'alumni_photo_' . md5($iin);

        return Cache::remember(
            $cacheKey,
            now()->addDays(self::CACHE_TTL),
            fn () => $this->resolvePhoto($iin)
        );
    }

    public function clearCache(string $iin): void
    {
        Cache::forget('alumni_photo_' . md5($iin));
    }

    private function resolvePhoto(string $iin): array
    {
        try {
            $person = DB::connection('iportal')
                ->table('portal_persons as pp')
                ->leftJoin('portal_persons_d as ppd', 'ppd.student_id', '=', 'pp.id')
                ->leftJoin('GRADUATES as grad', 'grad.iinPlt', '=', 'ppd.doc_iin')
                ->where(function ($q) use ($iin) {
                    $q->where('ppd.doc_iin', $iin)
                        ->orWhere('grad.iinPlt', $iin);
                })
                ->whereNotNull('pp.photo')
                ->where('pp.photo', '!=', '')
                ->select('pp.photo')
                ->first();

            if ($person && !empty($person->photo)) {
                $base64 = preg_replace('#^data:image/[^;]+;base64,#', '', (string) $person->photo);
                $decoded = base64_decode($base64);

                if ($decoded !== false && strlen($decoded) > 100) {
                    $cachedPath = self::PHOTOS_DIR . '/db_' . $iin . '.jpg';
                    Storage::disk('public')->put($cachedPath, $decoded);

                    return [
                        'type' => 'db_photo',
                        'value' => Storage::url($cachedPath),
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning('iPortal DB photo query failed for IIN ' . $iin . ': ' . $e->getMessage());
        }

        $mirrorPath = self::PHOTOS_DIR . '/' . $iin . '.png';
        if (Storage::disk('public')->exists($mirrorPath)) {
            return [
                'type' => 'mirror',
                'value' => Storage::url($mirrorPath),
            ];
        }

        return [
            'type' => 'default',
            'value' => asset('images/user.png'),
        ];
    }
}


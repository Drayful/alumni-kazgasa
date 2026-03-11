<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PortalPhotoService
{
    public function getPhotoForAlumni(string $iin): array
    {
        $info = DB::connection('iportal')
            ->table('portal_persons as pp')
            ->leftJoin('portal_persons_d as ppd', 'ppd.student_id', '=', 'pp.id')
            ->leftJoin('GRADUATES as grad', 'grad.iinPlt', '=', 'ppd.doc_iin')
            ->where(function ($q) use ($iin) {
                $q->where('ppd.doc_iin', $iin)
                    ->orWhere('grad.iinPlt', $iin);
            })
            ->select('pp.photo', 'ppd.doc_iin', 'grad.iinPlt')
            ->first();

        if (!$info) {
            return [
                'type' => 'default',
                'value' => asset('images/user.png'),
            ];
        }

        if (!empty($info->photo)) {
            try {
                $base64 = preg_replace('#^data:image/[^;]+;base64,#', '', (string) $info->photo);
                $decoded = base64_decode($base64, true);

                if ($decoded !== false && strlen($decoded) > 100) {
                    return [
                        'type' => 'base64',
                        'value' => 'data:image/jpeg;base64,' . base64_encode($decoded),
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning('Photo base64 decode failed for IIN: ' . $iin);
            }
        }

        $docIin = $info->doc_iin ?? $info->iinPlt ?? $iin;
        $url = 'https://iportal.mok.kz/intranet/student_photo/' . $docIin . '.png';

        try {
            $headers = @get_headers($url, 1);
            if ($headers && isset($headers[0]) && strpos((string) $headers[0], '404') === false) {
                return [
                    'type' => 'url',
                    'value' => $url,
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('Photo URL check failed: ' . $url);
        }

        return [
            'type' => 'default',
            'value' => asset('images/user.png'),
        ];
    }
}


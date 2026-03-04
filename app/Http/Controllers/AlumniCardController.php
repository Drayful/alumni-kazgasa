<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use Illuminate\Http\Response;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AlumniCardController extends Controller
{
    /**
     * Публичный экран «карты выпускника» по public_id.
     */
    public function show(string $publicId): View|Response
    {
        $alumniProfile = AlumniProfile::where('public_id', $publicId)->first();

        if (! $alumniProfile) {
            return response()->view('alumni.card-not-found', [], 404);
        }

        $cardUrl = route('alumni.card.show', ['publicId' => $alumniProfile->public_id]);

        $qrSvg = QrCode::format('svg')
            ->size(260)
            ->margin(0)
            ->generate($cardUrl);

        return view('alumni.card-screen', [
            'alumniProfile' => $alumniProfile,
            'cardUrl' => $cardUrl,
            'qrSvg' => $qrSvg,
        ]);
    }
}


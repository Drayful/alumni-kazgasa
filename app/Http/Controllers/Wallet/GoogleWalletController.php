<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use App\Services\GoogleWalletPassService;

class GoogleWalletController extends Controller
{
    public function redirectPublic(string $publicId, GoogleWalletPassService $service)
    {
        $profile = AlumniProfile::where('public_id', $publicId)->first();

        if (! $profile) {
            abort(404, 'Профиль выпускника не найден');
        }

        $url = $service->createSaveUrlForAlumni($profile);

        return redirect()->away($url);
    }
}


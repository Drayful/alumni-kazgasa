<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use App\Services\AppleWalletPassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AppleWalletController extends Controller
{
    public function download(Request $request, AppleWalletPassService $service)
    {
        $user = $request->user();
        $profile = $user?->alumniProfile;

        if (! $profile) {
            abort(404, 'Профиль выпускника не найден');
        }

        if (! $profile->public_id) {
            $profile->public_id = AlumniProfile::generatePublicId();
            $profile->save();
        }

        $result = $service->createPkPassForAlumni($profile);

        return response()->file($result['path'], [
            'Content-Type' => 'application/vnd.apple.pkpass',
            'Content-Disposition' => 'attachment; filename="'.$result['filename'].'"',
        ]);
    }

    public function downloadPublic(string $publicId, AppleWalletPassService $service)
    {
        $profile = AlumniProfile::where('public_id', $publicId)->first();

        if (! $profile) {
            abort(404, 'Профиль выпускника не найден');
        }

        $result = $service->createPkPassForAlumni($profile);

        return response()->file($result['path'], [
            'Content-Type' => 'application/vnd.apple.pkpass',
            'Content-Disposition' => 'attachment; filename="'.$result['filename'].'"',
        ]);
    }
}


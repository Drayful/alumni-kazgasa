<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AlumniCardController extends Controller
{
    /**
     * Публичный экран цифровой карты выпускника по public_id.
     * По этой ссылке открывается страница с картой, данными и статусом «является/не является выпускником».
     * QR на самой карте ведёт сюда.
     */
    public function show(string $publicId): View|Response
    {
        $alumniProfile = AlumniProfile::where('public_id', $publicId)->first();

        if (! $alumniProfile) {
            return response()->view('alumni.card-not-found', [], 404);
        }

        return view('alumni.card-screen', [
            'alumniProfile' => $alumniProfile,
        ]);
    }
}


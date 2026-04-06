<?php

namespace App\Http\Controllers;

use App\Models\ArchivePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivePhotoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user?->alumniProfile;

        if (! $profile || $profile->verification_status !== 'verified') {
            abort(403, 'Доступно только верифицированным выпускникам.');
        }

        $validated = $request->validate([
            // `image` может вызывать декодирование картинки и съедать память.
            // Для массовой/одиночной загрузки используем лёгкую проверку.
            // `max` в Laravel задается в килобайтах, 20480 = 20MB.
            'photo' => ['required', 'file', 'mimes:jpeg,jpg,png,webp', 'max:20480'],
            'decade' => ['required', 'string', 'in:'.implode(',', ArchivePhoto::DECADES)],
        ], [
            'photo.required' => 'Выберите фотографию',
            'photo.file' => 'Файл не получен. Попробуйте выбрать заново.',
            'photo.max' => 'Размер файла не более 20 МБ',
            'decade.required' => 'Выберите десятилетие',
        ]);

        $path = $request->file('photo')->store(
            'archive-photos/'.$user->id,
            'public'
        );

        ArchivePhoto::create([
            'user_id' => $user->id,
            'decade' => $validated['decade'],
            'path' => $path,
        ]);

        return redirect()->route('home')->withFragment('archive')->with('archive_success', __('site.flash.archive_photo_added'));
    }
}

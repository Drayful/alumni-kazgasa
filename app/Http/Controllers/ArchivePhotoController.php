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
            'photo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
            'decade' => ['required', 'string', 'in:'.implode(',', ArchivePhoto::DECADES)],
        ], [
            'photo.required' => 'Выберите фотографию',
            'photo.image' => 'Файл должен быть изображением',
            'photo.max' => 'Размер файла не более 10 МБ',
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

        return redirect()->route('home')->withFragment('archive')->with('archive_success', 'Фото добавлено в архив.');
    }
}

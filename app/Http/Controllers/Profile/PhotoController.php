<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ], [
            'photo.required' => 'Выберите фотографию',
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Допустимые форматы: JPEG, PNG, WebP',
            'photo.max' => 'Размер файла не должен превышать 2MB',
        ]);

        $profile = auth()->user()->alumniProfile;

        if (!$profile) {
            return back()->withErrors(['photo' => 'Профиль выпускника не найден.']);
        }

        if ($profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
        }

        $path = $request->file('photo')->store(
            'alumni-photos/' . auth()->id(),
            'public'
        );

        $profile->update(['photo_path' => $path]);

        return back()->with('photo_success', 'Фотография успешно обновлена!');
    }

    public function destroy()
    {
        $profile = auth()->user()->alumniProfile;

        if ($profile && $profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
            $profile->update(['photo_path' => null]);
        }

        return back()->with('photo_success', 'Фотография удалена. Используется фото из системы.');
    }
}

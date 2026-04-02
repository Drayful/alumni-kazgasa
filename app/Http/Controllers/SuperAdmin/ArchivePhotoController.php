<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ArchivePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ArchivePhotoController extends Controller
{
    public function index(Request $request): View
    {
        $decade = $request->query('decade');

        $query = ArchivePhoto::query()
            ->with('user:id,name,email')
            ->orderByDesc('created_at');

        if (is_string($decade) && $decade !== '' && in_array($decade, ArchivePhoto::DECADES, true)) {
            $query->where('decade', $decade);
        }

        $photos = $query->paginate(30)->withQueryString();

        return view('super-admin.archive-photos.index', [
            'photos' => $photos,
            'decade' => $decade,
            'decades' => ArchivePhoto::DECADES,
        ]);
    }

    public function destroy(ArchivePhoto $archivePhoto): RedirectResponse
    {
        if ($archivePhoto->path) {
            Storage::disk('public')->delete($archivePhoto->path);
        }
        $archivePhoto->delete();

        return back()->with('success', 'Фотография удалена.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:archive_photos,id'],
        ])['ids'];

        $photos = ArchivePhoto::query()->whereIn('id', $ids)->get();
        foreach ($photos as $p) {
            if ($p->path) {
                Storage::disk('public')->delete($p->path);
            }
            $p->delete();
        }

        return back()->with('success', 'Удалено фотографий: '.count($ids).'.');
    }

    public function bulkStore(Request $request): RedirectResponse
    {
        try {
            $incomingPhotos = $request->file('photos');
            $incomingCount = is_array($incomingPhotos) ? count($incomingPhotos) : ($incomingPhotos ? 1 : 0);

            Log::info('super-admin.bulkStore called', [
                'user_id' => $request->user()?->id,
                'decade' => $request->input('decade'),
                'files_count' => $incomingCount,
            ]);

            $validated = $request->validate([
                'decade' => ['required', 'string', 'in:'.implode(',', ArchivePhoto::DECADES)],
                'photos' => ['required', 'array', 'min:1', 'max:100'],
            ], [
                'photos.required' => 'Выберите хотя бы одну фотографию',
                'photos.max' => 'Не более 100 файлов за одну загрузку',
                'decade.required' => 'Выберите десятилетие',
            ]);

            $userId = $request->user()->id;
            $dir = 'archive-photos/'.$userId;
            $decade = $validated['decade'];

            $count = 0;
            $files = $request->file('photos');
            DB::transaction(function () use ($files, $userId, $dir, $decade, &$count) {
                $allowedExts = ['jpeg', 'jpg', 'png', 'webp'];
                $maxBytes = 20 * 1024 * 1024; // 20MB

                foreach ($files as $i => $file) {
                    if (! $file || ! $file->isValid()) {
                        // Если PHP не принял upload (limit/upload_tmp_dir), сюда попадет "failed to upload".
                        $errCode = $file?->getError();
                        throw ValidationException::withMessages([
                            'photos.'.$i => 'Файл не загрузился на сервер. Код ошибки: '.$errCode.'.',
                        ]);
                    }

                    $ext = strtolower((string) $file->getClientOriginalExtension());
                    if (! in_array($ext, $allowedExts, true)) {
                        throw ValidationException::withMessages([
                            'photos.'.$i => 'Недопустимый формат файла. Допустимые: JPEG, PNG, WebP.',
                        ]);
                    }

                    $size = (int) $file->getSize();
                    if ($size > $maxBytes) {
                        throw ValidationException::withMessages([
                            'photos.'.$i => 'Размер файла превышает 20 МБ.',
                        ]);
                    }

                    $path = $file->store($dir, 'public');
                    ArchivePhoto::create([
                        'user_id' => $userId,
                        'decade' => $decade,
                        'path' => $path,
                    ]);
                    $count++;
                }
            });

            if ($count === 0) {
                return back()->withErrors(['photos' => 'Не удалось сохранить файлы. Проверьте формат и размер.']);
            }

            return back()->with('success', 'Загружено фотографий: '.$count.'.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('super-admin.bulkStore failed', [
                'user_id' => $request->user()?->id,
                'decade' => $request->input('decade'),
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['bulk' => 'Ошибка загрузки фотографий. Проверьте файл/лимиты и повторите.']);
        }
    }
}

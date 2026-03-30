<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ArchivePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
}

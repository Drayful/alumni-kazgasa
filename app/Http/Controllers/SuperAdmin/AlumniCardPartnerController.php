<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AlumniCardPartner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniCardPartnerController extends Controller
{
    public function index(): View
    {
        $partners = AlumniCardPartner::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('super-admin.alumni-card-partners.index', compact('partners'));
    }

    public function create(): View
    {
        $partner = new AlumniCardPartner([
            'is_active' => true,
            'sort_order' => (int) (AlumniCardPartner::query()->max('sort_order') ?? 0) + 10,
            'discount' => 'X%',
            'logo_letter' => '?',
        ]);

        return view('super-admin.alumni-card-partners.form', [
            'partner' => $partner,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AlumniCardPartner::create($this->validated($request));

        return redirect()->route('super-admin.alumni-card-partners.index')->with('success', 'Партнёр добавлен.');
    }

    public function edit(AlumniCardPartner $alumniCardPartner): View
    {
        return view('super-admin.alumni-card-partners.form', [
            'partner' => $alumniCardPartner,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, AlumniCardPartner $alumniCardPartner): RedirectResponse
    {
        $alumniCardPartner->update($this->validated($request));

        return redirect()->route('super-admin.alumni-card-partners.index')->with('success', 'Партнёр обновлён.');
    }

    public function destroy(AlumniCardPartner $alumniCardPartner): RedirectResponse
    {
        $alumniCardPartner->delete();

        return back()->with('success', 'Партнёр удалён.');
    }

    public function toggle(AlumniCardPartner $alumniCardPartner): RedirectResponse
    {
        $alumniCardPartner->is_active = ! $alumniCardPartner->is_active;
        $alumniCardPartner->save();

        return back()->with('success', $alumniCardPartner->is_active ? 'Партнёр включён.' : 'Партнёр скрыт.');
    }

    public function move(AlumniCardPartner $alumniCardPartner, Request $request): RedirectResponse
    {
        $direction = (string) $request->query('direction', '');
        if (! in_array($direction, ['up', 'down'], true)) {
            return back()->with('error', 'Неверное направление сортировки.');
        }

        $ordered = AlumniCardPartner::query()->orderBy('sort_order')->orderBy('id')->get();
        $idx = $ordered->search(fn ($p) => (int) $p->id === (int) $alumniCardPartner->id);
        if ($idx === false) {
            return back()->with('error', 'Запись не найдена.');
        }

        $swapWith = $direction === 'up' ? $idx - 1 : $idx + 1;
        if ($swapWith < 0 || $swapWith >= $ordered->count()) {
            return back();
        }

        $a = $ordered[$idx];
        $b = $ordered[$swapWith];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return back();
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'discount' => ['required', 'string', 'max:32'],
            'description' => ['required', 'string'],
            'logo_letter' => ['required', 'string', 'max:8'],
            'popup' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['note'] = $data['note'] ?? null;

        return $data;
    }
}

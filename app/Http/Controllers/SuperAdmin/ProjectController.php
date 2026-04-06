<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()->orderBy('sort_order')->orderBy('title')->get();

        return view('super-admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $project = new Project([
            'is_active' => true,
            'sort_order' => 0,
            'icon' => '🎓',
        ]);

        return view('super-admin.projects.form', [
            'project' => $project,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        Project::create($data);

        return redirect()->route('super-admin.projects.index')->with('success', 'Проект создан.');
    }

    public function edit(Project $project)
    {
        return view('super-admin.projects.form', [
            'project' => $project,
            'mode' => 'edit',
        ]);
    }

    public function update(Project $project, Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $project->update($data);

        return redirect()->route('super-admin.projects.index')->with('success', 'Проект обновлён.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return back()->with('success', 'Проект удалён.');
    }

    public function toggle(Project $project): RedirectResponse
    {
        $project->is_active = ! $project->is_active;
        $project->save();

        return back()->with('success', $project->is_active ? 'Проект включён.' : 'Проект скрыт.');
    }

    public function move(Project $project, Request $request): RedirectResponse
    {
        $direction = (string) $request->query('direction', '');
        if (! in_array($direction, ['up', 'down'], true)) {
            return back()->with('error', 'Неверное направление сортировки.');
        }

        $ordered = Project::query()->orderBy('sort_order')->orderBy('id')->get();
        $idx = $ordered->search(fn ($p) => (int) $p->id === (int) $project->id);
        if ($idx === false) {
            return back()->with('error', 'Проект не найден в списке.');
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
        $rules = [
            'icon' => ['required', 'string', 'max:20'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['nullable'],
            'translations' => ['required', 'array'],
            'translations.kk' => ['required', 'array'],
            'translations.ru' => ['required', 'array'],
            'translations.en' => ['required', 'array'],
        ];

        $fields = ['title', 'tags', 'button_text', 'short', 'how_it_works', 'what_you_get'];
        $ruRequired = ['title', 'button_text', 'short', 'how_it_works', 'what_you_get'];

        foreach (['kk', 'ru', 'en'] as $loc) {
            foreach ($fields as $f) {
                $req = $loc === 'ru' && in_array($f, $ruRequired, true);
                $shortish = in_array($f, ['title', 'tags', 'button_text'], true);
                $rules["translations.$loc.$f"] = $shortish
                    ? ($req ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'])
                    : ($req ? ['required', 'string'] : ['nullable', 'string']);
            }
        }

        $data = $request->validate($rules);

        $translations = Project::normalizeTranslationsInput($data['translations'], $fields);
        $data['translations'] = $translations;

        $data['title'] = $translations['ru']['title'];
        $data['tags'] = $translations['ru']['tags'] !== '' ? $translations['ru']['tags'] : null;
        $data['button_text'] = $translations['ru']['button_text'];
        $data['short'] = $translations['ru']['short'];
        $data['how_it_works'] = $translations['ru']['how_it_works'];
        $data['what_you_get'] = $translations['ru']['what_you_get'];

        $data['is_active'] = (bool) $request->boolean('is_active');

        return $data;
    }
}


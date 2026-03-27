<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectApplicationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'contact' => ['required', 'string', 'max:255'],
        ]);

        $project = Project::query()->findOrFail($validated['project_id']);

        ProjectApplication::create([
            'name' => $validated['name'],
            'company' => $validated['company'] ?? null,
            'project_id' => (int) $validated['project_id'],
            'contact' => $validated['contact'],
            'status' => 'new',
        ]);

        return back()
            ->with('success', 'Отлично! Мы свяжемся с вами в течение 2 рабочих дней.')
            ->withFragment('projects-form')
            ->withInput(['project_id' => $project->id]);
    }
}


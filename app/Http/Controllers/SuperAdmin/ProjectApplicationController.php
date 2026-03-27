<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectApplicationController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('project_id');

        $projects = Project::query()->orderBy('sort_order')->orderBy('title')->get();

        $query = ProjectApplication::query()
            ->with('project')
            ->orderByDesc('created_at');

        if (is_string($projectId) && $projectId !== '') {
            $query->where('project_id', (int) $projectId);
        }

        $applications = $query->paginate(20)->withQueryString();

        return view('super-admin.project-applications.index', compact('applications', 'projects', 'projectId'));
    }

    public function updateStatus(ProjectApplication $application, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,done'],
        ]);

        $application->status = $validated['status'];
        $application->save();

        return back()->with('success', 'Статус обновлён.');
    }
}


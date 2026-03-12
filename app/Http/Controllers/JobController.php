<?php

namespace App\Http\Controllers;

use App\Services\JobService;

class JobController extends Controller
{
    public function __construct(private JobService $jobService)
    {
    }

    public function index()
    {
        $jobs = $this->jobService->getActiveJobs();

        return view('jobs.index', compact('jobs'));
    }

    public function show(int $id)
    {
        $job = $this->jobService->getJobById($id);

        if (! $job) {
            abort(404, 'Вакансия не найдена или уже закрыта');
        }

        return view('jobs.show', compact('job'));
    }
}

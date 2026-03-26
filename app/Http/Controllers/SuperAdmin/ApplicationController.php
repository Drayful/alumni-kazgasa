<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PartnerApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = PartnerApplication::query()->orderByDesc('created_at');
        if (is_string($status) && $status !== '') {
            $query->where('status', $status);
        }

        $applications = $query->paginate(25)->withQueryString();

        return view('super-admin.applications.index', compact('applications', 'status'));
    }

    public function show(PartnerApplication $application)
    {
        return view('super-admin.applications.show', compact('application'));
    }

    public function approve(PartnerApplication $application)
    {
        $application->status = 'approved';
        $application->processed_at = now();
        $application->save();

        return back()->with('success', 'Заявка отмечена как одобренная.');
    }

    public function reject(PartnerApplication $application)
    {
        $application->status = 'rejected';
        $application->processed_at = now();
        $application->save();

        return back()->with('success', 'Заявка отмечена как отклонённая.');
    }

    public function suspend(PartnerApplication $application)
    {
        $application->status = 'suspended';
        $application->processed_at = now();
        $application->save();

        return back()->with('success', 'Заявка отмечена как приостановленная.');
    }
}

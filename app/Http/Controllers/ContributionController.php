<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ContributionController extends Controller
{
    public function index(): View
    {
        return view('contributions.index');
    }
}


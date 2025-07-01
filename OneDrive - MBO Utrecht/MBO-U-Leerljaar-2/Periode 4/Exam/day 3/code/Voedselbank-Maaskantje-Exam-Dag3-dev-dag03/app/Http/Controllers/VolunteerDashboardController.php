<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class VolunteerDashboardController extends Controller
{
    /**
     * Display the volunteer dashboard.
     */
    public function index(): View
    {
        return view('dashboards.volunteer');
    }
}

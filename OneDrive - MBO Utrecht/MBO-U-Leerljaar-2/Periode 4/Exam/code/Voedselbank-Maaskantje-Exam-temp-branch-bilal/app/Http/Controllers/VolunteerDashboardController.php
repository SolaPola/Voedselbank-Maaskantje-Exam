<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerDashboardController extends Controller
{
    public function index()
    {
        // Mock data for volunteer activities
        $upcomingShifts = 3;
        $hoursThisMonth = 24;
        $familiesHelped = 15;

        return view('dashboards.volunteer', compact(
            'upcomingShifts',
            'hoursThisMonth',
            'familiesHelped'
        ));
    }
}

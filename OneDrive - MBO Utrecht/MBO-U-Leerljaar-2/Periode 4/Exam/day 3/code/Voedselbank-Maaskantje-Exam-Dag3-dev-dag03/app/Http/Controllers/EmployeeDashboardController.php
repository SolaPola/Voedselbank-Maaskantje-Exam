<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeDashboardController extends Controller
{
    /**
     * Display the employee dashboard.
     */
    public function index(): View
    {
        return view('dashboards.employee');
    }
}

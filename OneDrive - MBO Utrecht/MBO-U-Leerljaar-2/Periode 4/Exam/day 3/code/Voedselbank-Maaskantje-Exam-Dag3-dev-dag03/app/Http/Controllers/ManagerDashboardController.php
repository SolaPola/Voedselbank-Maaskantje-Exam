<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerDashboardController extends Controller
{
    /**
     * Display the manager dashboard.
     */
    public function index(): View
    {
        return view('dashboards.manager');
    }
}

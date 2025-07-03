<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $warehouseWorkerCount = User::where('role', 'warehouse_worker')->count();
        $volunteerCount = User::where('role', 'volunteer')->count();

        return view('dashboards.admin', compact(
            'totalUsers',
            'adminCount',
            'warehouseWorkerCount',
            'volunteerCount'
        ));
    }
}

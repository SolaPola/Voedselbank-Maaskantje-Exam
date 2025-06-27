<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseWorkerDashboardController extends Controller
{
    public function index()
    {
        // Mock data for warehouse operations
        $inventoryItems = 45;
        $pendingDeliveries = 12;
        $completedToday = 8;

        return view('dashboards.warehouse-worker', compact(
            'inventoryItems',
            'pendingDeliveries',
            'completedToday'
        ));
    }
}

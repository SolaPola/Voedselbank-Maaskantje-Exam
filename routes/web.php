<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WarehouseWorkerDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'warehouse_worker':
            return redirect()->route('warehouse.dashboard');
        case 'volunteer':
        default:
            return redirect()->route('volunteer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboard routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Add supplier routes to admin middleware group
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
});

Route::middleware(['auth', 'warehouse.worker'])->group(function () {
    Route::get('/warehouse/dashboard', [WarehouseWorkerDashboardController::class, 'index'])->name('warehouse.dashboard');
});

Route::middleware(['auth', 'volunteer'])->group(function () {
    Route::get('/volunteer/dashboard', [VolunteerDashboardController::class, 'index'])->name('volunteer.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

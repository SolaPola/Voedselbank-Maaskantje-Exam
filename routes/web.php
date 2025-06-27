<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WarehouseWorkerDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodPackageController;

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

    Route::resource('foodpackages', FoodPackageController::class);
    Route::get('/foodpackages', [FoodPackageController::class, 'index'])->name('foodpackages.index');
    Route::get('/foodpackages/create', [FoodPackageController::class, 'create'])->name('foodpackages.create');
    Route::post('/foodpackages', [FoodPackageController::class, 'store'])->name('foodpackages.store');
    Route::get('/foodpackages/{foodpackage}', [FoodPackageController::class, 'show'])->name('foodpackages.show');
    Route::get('/foodpackages/{foodpackage}/edit', [FoodPackageController::class, 'edit'])->name('foodpackages.edit');
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
    Route::get('/voorraad', [App\Http\Controllers\ProductController::class, 'index'])->name('voorraad.index');
});

require __DIR__ . '/auth.php';

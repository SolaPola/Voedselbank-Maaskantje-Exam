<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WarehouseWorkerDashboardController;
use App\Http\Controllers\VolunteerDashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


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

    Route::get('/admin/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/admin/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/admin/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/admin/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/admin/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/admin/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/admin/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    


    
    // Supplier routes with full resource
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');



    Route::get('/admin/clients', [ClientController::class, 'index'])->name('clients.index');
});

Route::middleware(['auth', 'warehouse.worker'])->group(function () {
    Route::get('/warehouse/dashboard', [WarehouseWorkerDashboardController::class, 'index'])->name('warehouse.dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
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

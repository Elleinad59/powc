<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Console\Commands\SyncData;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\PurchaseOrderController;

use App\Http\Controllers\SyncController;

Route::get('/sync-data', [SyncController::class, 'syncData'])->name('sync.data');

Route::get('/purchase_orders', [PurchaseOrderController::class, 'index'])->name('purchase_order.index');
Route::get('/purchase_orders/{id}', [PurchaseOrderController::class, 'show'])->name('purchase_order.show');
Route::get('/purchase_orders/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase_order.edit');
Route::put('/purchase_orders/{id}', [PurchaseOrderController::class, 'update'])->name('purchase_order.update');



// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle login request
Route::post('/login', [AuthController::class, 'login']);

// Handle logout request
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (example)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

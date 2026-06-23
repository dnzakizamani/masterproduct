<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products - Custom routes BEFORE resource (to avoid conflict)
        Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
        Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore')
            ->where('id', '[0-9]+');
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete')
            ->where('id', '[0-9]+');
        
        // Products - Resource routes AFTER custom routes
        Route::resource('products', ProductController::class);

        // Transactions
        Route::resource('transactions', TransactionController::class);
    });

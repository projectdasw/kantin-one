<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'prevent.back'])->group(function () {
    
    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'administrator' => redirect()->route('admin.dashboard'),
            'canteen_manager' => redirect()->route('manager.dashboard'),
            'tenant' => redirect()->route('tenant.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    // Administrator
    Route::middleware('role:administrator')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::view('/dashboard', 'dashboards.admin')
                ->name('dashboard');
        });

    // Pengelola Kantin
    Route::middleware('role:canteen_manager')
        ->prefix('manager')
        ->name('manager.')
        ->group(function () {
            Route::view('/dashboard', 'dashboards.manager')
                ->name('dashboard');
        });

    // Tenant
    Route::middleware('role:tenant')
        ->prefix('tenant')
        ->name('tenant.')
        ->group(function () {
            Route::view('/dashboard', 'dashboards.tenant')
                ->name('dashboard');
        });
});

<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\CustomerCartController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {
        'super_admin', 'administrator' => redirect()->route('dashboard'),
        'canteen_manager' => redirect()->route('dashboard.canteen_manager'),
        'tenant', 'tenant_employee' => redirect()->route('dashboard.tenant'),
        default => abort(403),
    };
});

/* Order Page - Customer */
/* -------------------------------------------------------------------------- */
/*
|--------------------------------------------------------------------------
| Customer Ordering
|--------------------------------------------------------------------------
*/

Route::prefix('orders')->name('customer.')->group(function () {
    Route::get('/', [CustomerOrderController::class, 'index'])
        ->name('index');

    Route::get('/tenant', [CustomerOrderController::class, 'tenants'])
        ->name('tenants');

    Route::get('/tenant/{tenant:code}', [CustomerOrderController::class, 'products'])
        ->name('products');

    Route::post('/cart/items/{product}/increase', [CustomerCartController::class, 'increase'])
        ->name('cart.increase');

    Route::post('/cart/items/{product}/decrease', [CustomerCartController::class, 'decrease'])
        ->name('cart.decrease');

    Route::post('/cart/items/{productId}/remove', [CustomerCartController::class, 'remove'])
        ->name('cart.remove');

    Route::post('/service', [CustomerOrderController::class, 'storeService'])
        ->name('service.store');

    // Route::post('/checkout/details', [CustomerOrderController::class, 'storeCheckoutDetails'])
    //     ->name('checkout.details');

    Route::post('/checkout/place-order', [CustomerOrderController::class, 'placeOrder'])
        ->name('checkout.place-order');

    Route::get('/payment', [CustomerOrderController::class, 'payment'])
        ->name('payment');

    Route::get('/payment/status', [CustomerOrderController::class, 'paymentStatus'])
        ->name('payment.status');

    Route::post('/payment/simulate', [CustomerOrderController::class, 'simulatePayment'])
        ->name('payment.simulate');

    Route::post('/payment/simulate-failure', [CustomerOrderController::class, 'simulatePaymentFailure'])
        ->name('payment.simulate-failure');

    Route::post('/payment/retry', [CustomerOrderController::class, 'retryPayment'])
        ->name('payment.retry');
});

Route::get('/orders/cart', [CustomerOrderController::class, 'cart'])
    ->name('customer.cart');

Route::get('/orders/checkout', [CustomerOrderController::class, 'checkout'])
    ->name('customer.checkout');

Route::get('/orders/history', [CustomerOrderController::class, 'history'])
    ->name('customer.history');

Route::post('/orders/history/search', [CustomerOrderController::class, 'searchHistory'])
    ->name('customer.history.search');

Route::get('/orders/status', function () {
    return view('customer.status');
})->name('customer.status');

// Route::get('/orders/payment', function () {
//     return view('customer.pay');
// })->name('customer.pay');

// Route::get('/orders/payment_status', function () {
//     return view('customer.paycomplete');
// })->name('customer.paycomplete');
/* -------------------------------------------------------------------------- */

Route::middleware(['auth', 'auth.session', 'prevent.back', 'role:administrator'])->group(function () {

    /* Login Page */
    /* -------------------------------------------------------------------------- */
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    /* -------------------------------------------------------------------------- */

    /* User Management */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/search', [UserController::class, 'index'])
        ->name('users.search');

    /* Index & Create */
    /* -------------------------------------------------------------------------- */
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');
    /* -------------------------------------------------------------------------- */

    /* Detail & Edit: pilih pengguna melalui POST */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/detail', [UserController::class, 'selectDetail'])
        ->name('users.select-detail');

    Route::get('/users/detail', [UserController::class, 'show'])
        ->name('users.show');

    Route::post('/users/edit', [UserController::class, 'selectEdit'])
        ->name('users.select-edit');

    Route::get('/users/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/edit', [UserController::class, 'update'])
        ->name('users.update');
    /* -------------------------------------------------------------------------- */

    /* Status & Delete */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');

    Route::post('/users/delete', [UserController::class, 'destroy'])
        ->name('users.destroy');
    /* -------------------------------------------------------------------------- */

    /* Trash, Restore & Permanent Delete */
    /* -------------------------------------------------------------------------- */
    Route::get('/users/trash', [UserController::class, 'trash'])
        ->name('users.trash');

    Route::post('/users/restore', [UserController::class, 'restore'])
        ->name('users.restore');

    Route::post('/users/forcedelete', [UserController::class, 'forceDelete'])
        ->name('users.force-delete');
    /* -------------------------------------------------------------------------- */

    /* Reset Password */
    /* -------------------------------------------------------------------------- */
    Route::post('/users/resetpassword/start', [UserController::class, 'startPasswordReset'])
        ->name('users.resetpassword.start');

    Route::get('/users/resetpassword', [UserController::class, 'editPassword'])
        ->name('users.resetpassword.edit');

    Route::patch('/users/resetpassword', [UserController::class, 'updatePassword'])
        ->name('users.resetpassword.update');
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */

    /* Tenant Management */
    /* -------------------------------------------------------------------------- */
    /* Index & Search */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/search', [TenantController::class, 'index'])
        ->name('tenants.search');

    Route::get('/tenants', [TenantController::class, 'index'])
        ->name('tenants.index');
    /* -------------------------------------------------------------------------- */

    /* Create */
    /* -------------------------------------------------------------------------- */
    Route::get('/tenants/create', [TenantController::class, 'create'])
        ->name('tenants.create');

    Route::post('/tenants', [TenantController::class, 'store'])
        ->name('tenants.store');
    /* -------------------------------------------------------------------------- */

    /* Detail */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/detail', [TenantController::class, 'selectDetail'])
        ->name('tenants.select-detail');

    Route::get('/tenants/detail', [TenantController::class, 'show'])
        ->name('tenants.show');
    /* -------------------------------------------------------------------------- */

    /* Edit */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/edit', [TenantController::class, 'selectEdit'])
        ->name('tenants.select-edit');

    Route::get('/tenants/edit', [TenantController::class, 'edit'])
        ->name('tenants.edit');

    Route::put('/tenants/edit', [TenantController::class, 'update'])
        ->name('tenants.update');
    /* -------------------------------------------------------------------------- */

    /* Status & Delete */
    /* -------------------------------------------------------------------------- */
    Route::post('/tenants/status', [TenantController::class, 'toggleStatus'])
        ->name('tenants.toggle-status');

    Route::post('/tenants/delete', [TenantController::class, 'destroy'])
        ->name('tenants.destroy');
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */

    /* Canteen Management */
    /* -------------------------------------------------------------------------- */

    /* Index & Search */
    Route::post('/canteens/search', [CanteenController::class, 'index'])
        ->name('canteens.search');

    Route::get('/canteens', [CanteenController::class, 'index'])
        ->name('canteens.index');

    /* Create */
    Route::get('/canteens/create', [CanteenController::class, 'create'])
        ->name('canteens.create');

    Route::post('/canteens', [CanteenController::class, 'store'])
        ->name('canteens.store');

    /* Detail */
    Route::post('/canteens/detail', [CanteenController::class, 'selectDetail'])
        ->name('canteens.select-detail');

    Route::get('/canteens/detail', [CanteenController::class, 'show'])
        ->name('canteens.show');

    /* Edit */
    Route::post('/canteens/edit', [CanteenController::class, 'selectEdit'])
        ->name('canteens.select-edit');

    Route::get('/canteens/edit', [CanteenController::class, 'edit'])
        ->name('canteens.edit');

    Route::put('/canteens/edit', [CanteenController::class, 'update'])
        ->name('canteens.update');

    /* Status & Delete */
    Route::post('/canteens/status', [CanteenController::class, 'toggleStatus'])
        ->name('canteens.toggle-status');

    Route::post('/canteens/delete', [CanteenController::class, 'destroy'])
        ->name('canteens.destroy');

    // Master Gedung
    Route::prefix('buildings')->name('buildings.')->controller(BuildingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/search', 'index')->name('search');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::post('/detail', 'selectDetail')->name('detail.select');
        Route::get('/detail', 'show')->name('show');

        Route::post('/edit', 'selectEdit')->name('edit.select');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/edit', 'update')->name('update');

        Route::post('/status', 'toggleStatus')->name('status');
        Route::post('/delete', 'destroy')->name('destroy');
    });

    Route::prefix('floors')->name('floors.')->controller(FloorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/search', 'index')->name('search');
        Route::post('/detail', 'selectDetail')->name('detail.select');
        Route::get('/detail', 'show')->name('show');
        Route::post('/edit', 'selectEdit')->name('edit.select');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/edit', 'update')->name('update');
        Route::post('/status', 'toggleStatus')->name('status');
        Route::post('/delete', 'destroy')->name('destroy');
    });

    /* -------------------------------------------------------------------------- */

    /* Product Management */
    /* -------------------------------------------------------------------------- */

    /* Index & Search */
    Route::post('/products/search', [ProductController::class, 'index'])
        ->name('products.search');

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    /* Create */
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    /* Detail */
    Route::post('/products/detail', [ProductController::class, 'selectDetail'])
        ->name('products.select-detail');

    Route::get('/products/detail', [ProductController::class, 'show'])
        ->name('products.show');

    /* Edit */
    Route::post('/products/edit', [ProductController::class, 'selectEdit'])
        ->name('products.select-edit');

    Route::get('/products/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/edit', [ProductController::class, 'update'])
        ->name('products.update');

    /* Availability & Delete */
    Route::post('/products/status', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');

    Route::post('/products/delete', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::get('/products/trash', [ProductController::class, 'trash'])
        ->name('products.trash');

    Route::post('/products/restore', [ProductController::class, 'restore'])
        ->name('products.restore');

    Route::post('/products/force-delete', [ProductController::class, 'forceDelete'])
        ->name('products.force-delete');

    /* -------------------------------------------------------------------------- */
    /* Table Management */
    /* -------------------------------------------------------------------------- */

    /* Index & Search */
    Route::post('/tables/search', [TableController::class, 'index'])
        ->name('tables.search');

    Route::get('/tables', [TableController::class, 'index'])
        ->name('tables.index');

    /* Create */
    Route::get('/tables/create', [TableController::class, 'create'])
        ->name('tables.create');

    Route::post('/tables', [TableController::class, 'store'])
        ->name('tables.store');

    /* Detail */
    Route::post('/tables/detail', [TableController::class, 'selectDetail'])
        ->name('tables.select-detail');

    Route::get('/tables/detail', [TableController::class, 'show'])
        ->name('tables.show');

    /* Edit */
    Route::post('/tables/edit', [TableController::class, 'selectEdit'])
        ->name('tables.select-edit');

    Route::get('/tables/edit', [TableController::class, 'edit'])
        ->name('tables.edit');

    Route::put('/tables/edit', [TableController::class, 'update'])
        ->name('tables.update');

    /* Status & Delete */
    Route::post('/tables/status', [TableController::class, 'toggleStatus'])
        ->name('tables.toggle-status');

    Route::post('/tables/delete', [TableController::class, 'destroy'])
        ->name('tables.destroy');

    /* Trash, Restore & Permanent Delete */
    Route::get('/tables/trash', [TableController::class, 'trash'])
        ->name('tables.trash');

    Route::post('/tables/restore', [TableController::class, 'restore'])
        ->name('tables.restore');

    Route::post('/tables/force-delete', [TableController::class, 'forceDelete'])
        ->name('tables.force-delete');
});
/* -------------------------------------------------------------------------- */

/* Dashboard - Kepala Pengelola Tenant */
/* -------------------------------------------------------------------------- */
Route::middleware(['auth', 'auth.session', 'prevent.back', 'role:canteen_manager'])->group(function () {
    Route::get('/pengelola-tenant/dashboard', function () {
        return view('dashboard.canteen_manager.index');
    })->name('dashboard.canteen_manager');

    Route::get('/pengelola-tenant/meja', [TableController::class, 'monitor'])
        ->name('tables.monitor');

    Route::get('/tenant/pesanan', function () {
        return view('orders.tenant.index');
    })->name('tenant.orders.index');

    Route::get('/tenant/penjualan', function () {
        return view('orders.tenant.sales');
    })->name('tenant.sales.index');

    Route::get('/tenant/dashboard', function () {
        return view('orders.tenant.dashboard');
    })->name('tenant.dashboard');

    Route::get('/tenant/produk', function () {
        return view('orders.tenant.products');
    })->name('tenant.products.index');
});
/* -------------------------------------------------------------------------- */

/* Dashboard - Kepala Tenant & Pegawai Tenant */
/* -------------------------------------------------------------------------- */
Route::middleware(['auth', 'auth.session', 'prevent.back', 'role:tenant,tenant_employee'])->group(function () {
    Route::get('/tenant/dashboard', function () {
        return view('dashboard.tenant.index');
    })->name('dashboard.tenant');

    Route::get('/tenant/produk_tenant', function () {
        return view('dashboard.tenant.products');
    })->name('tenant.produk_tenant');

    Route::get('/tenant/penjualan_tenant', function () {
        return view('dashboard.tenant.sales');
    })->name('tenant.penjualan_tenant');

    Route::get('/tenant/products', function () {
        return view('dashboard.tenant.products.index');
    })->name('tenant.products');

    Route::get('/tenant/sales', function () {
        return view('dashboard.tenant.sales.index');
    })->name('tenant.sales');
});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\PinjamanController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\LandingController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\AuthController;

// ... kode route lainnya ...

// Rute khusus untuk memproses Login
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');

// Rute khusus untuk Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
->middleware(['admin.auth'])
->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/dashboard/order/{id}/payment-status',
        [DashboardController::class, 'updatePaymentStatus'])
        ->name('admin.dashboard.order.payment-status');

    Route::post('/dashboard/order/manual',
        [DashboardController::class, 'storeManualOrder'])
        ->name('admin.dashboard.order.manual');

    Route::post('/logout',
        [DashboardController::class, 'logout'])
        ->name('admin.logout');


    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan',
        [LaporanController::class, 'index'])
        ->name('admin.laporan');

    Route::get('/laporan/data',
        [LaporanController::class, 'data'])
        ->name('admin.laporan.data');

    Route::post('/laporan/export',
        [LaporanController::class, 'exportPdf'])
        ->name('admin.laporan.export');


    /*
    |--------------------------------------------------------------------------
    | Katalog
    |--------------------------------------------------------------------------
    */

    Route::get('/katalog',
        [KatalogController::class, 'index'])
        ->name('admin.katalog');

    Route::post('/katalog/store',
        [KatalogController::class, 'store'])
        ->name('admin.katalog.store');

    Route::post('/katalog/update/{id}',
        [KatalogController::class, 'update'])
        ->name('admin.katalog.update');

    Route::delete('/katalog/delete/{id}',
        [KatalogController::class, 'destroy'])
        ->name('admin.katalog.delete');


    /*
    |--------------------------------------------------------------------------
    | Pinjaman
    |--------------------------------------------------------------------------
    */

    Route::get('/pinjaman',
        [PinjamanController::class, 'index'])
        ->name('admin.pinjaman');

    Route::get('/pinjaman/{id}',
        [PinjamanController::class, 'show'])
        ->name('admin.pinjaman.show');

    Route::post('/pinjaman/{id}/approve',
        [PinjamanController::class, 'approve'])
        ->name('admin.pinjaman.approve');

    Route::post('/pinjaman/{id}/reject',
        [PinjamanController::class, 'reject'])
        ->name('admin.pinjaman.reject');

    Route::post('/pinjaman/{id}/cetak',
        [PinjamanController::class, 'cetakPdf'])
        ->name('admin.pinjaman.cetak');

    Route::get('/pinjaman/{id}/print',
        [PinjamanController::class, 'print'])
        ->name('admin.pinjaman.print');

    Route::get('/users/{id}/pinjaman',
        [PinjamanController::class, 'riwayatUser'])
        ->name('admin.user.pinjaman');


    /*
    |--------------------------------------------------------------------------
    | Admin Users
    |--------------------------------------------------------------------------
    */

    Route::get('/data-admin',
        [AdminUserController::class, 'index'])
        ->name('admin.data-admin');


    /*
    |--------------------------------------------------------------------------
    | Super Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware(['superadmin'])->group(function () {

        Route::post('/data-admin/store',
            [AdminUserController::class, 'store'])
            ->name('admin.data-admin.store');

        Route::post('/data-admin/update/{id}',
            [AdminUserController::class, 'update'])
            ->name('admin.data-admin.update');

        Route::delete('/data-admin/delete/{id}',
            [AdminUserController::class, 'destroy'])
            ->name('admin.data-admin.delete');

        Route::post('/data-admin/reset-password/{id}',
            [AdminUserController::class, 'resetPassword'])
            ->name('admin.data-admin.reset');


        /*
        |--------------------------------------------------------------------------
        | Users Management
        |--------------------------------------------------------------------------
        */

        Route::post('/users/update/{id}',
            [UserController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/users/delete/{id}',
            [UserController::class, 'destroy'])
            ->name('admin.users.delete');

    });


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get('/users',
        [UserController::class, 'index'])
        ->name('admin.users');

    Route::post('/users/store',
        [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/users/{id}',
        [UserController::class, 'show'])
        ->name('admin.users.show');

    Route::get('/users/{id}/orders',
        [UserController::class, 'orders'])
        ->name('admin.users.orders');

});


Route::prefix('user')->group(function () {

    Route::get('/home',
        [LandingController::class, 'landing']
    )->name('user.landing');

    Route::get('/belanja',
        [LandingController::class, 'belanja']
    )->name('user.belanja');

    Route::get('/pinjaman',
        [LandingController::class, 'pinjaman']
    )->name('user.pinjaman');

    Route::post('/pinjaman',
        [LandingController::class, 'submitPinjaman']
    )->name('user.pinjaman.submit');

    Route::get('/riwayat',
        [LandingController::class, 'riwayat']
    )->name('user.riwayat');

    Route::get('/riwayat/{id}',
        [LandingController::class, 'riwayatDetail']
    )->name('user.riwayat.detail');

    Route::get('/cart',
        [CartController::class,'index'])
        ->name('user.cart');

    Route::post('/cart/add/{id}',
        [CartController::class,'add'])
        ->name('user.cart.add');

    Route::get('/cart/remove/{id}',
        [CartController::class,'remove'])
        ->name('user.cart.remove');

    Route::post('/cart/update/{id}',
        [CartController::class,'update'])
        ->name('user.cart.update');

    Route::post('/checkout',
        [CartController::class,'checkout'])
        ->name('user.checkout');


});

// Rute untuk halaman utama (Pintu Depan)
Route::get('/', function () {
    // Opsional: Langsung arahkan ke halaman landing user
    return redirect()->route('user.landing');
});

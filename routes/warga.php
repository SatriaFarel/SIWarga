<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    WargaController,
    ArtikelController,
    AgendaController,
    IuranController,
    InformasiController,
    HomeController,
    ArsipController,
    WargaLoginController
};

/*
|--------------------------------------------------------------------------
| WARGA AUTH ROUTES
|--------------------------------------------------------------------------
| Custom authentication for warga using session
| Session keys:
| - warga_login (boolean)
| - warga_id    (integer)
|--------------------------------------------------------------------------
*/

/**
 * Warga login page
 */
Route::get('/warga/login', [WargaLoginController::class, 'showLogin'])
    ->name('warga.login');

/**
 * Warga login process
 * Set session: warga_login & warga_id
 */
Route::post('/warga/login', [WargaLoginController::class, 'login'])
    ->name('warga.login.process');

/**
 * Warga logout
 * Clear all warga session data
 */
Route::post('/warga/logout', [WargaLoginController::class, 'logout'])
    ->name('warga.logout');


/*
|--------------------------------------------------------------------------
| WARGA PROTECTED ROUTES
|--------------------------------------------------------------------------
| Manual session check (without middleware)
|--------------------------------------------------------------------------
*/

/**
 * Warga dashboard
 * Only accessible if session warga_login exists
 */
Route::get('/warga/dashboard', function () {

    // Session check (manual auth)
    if (!session()->get('warga_login') || !session()->has('warga_id')) {
        return redirect()->route('warga.login');
    }

    return app(WargaController::class)->dashboard();

})->name('warga.dashboard');

/**
 * Struk pembayaran iuran
 * Only accessible after payment (session struk exists)
 */
Route::get('/warga/struk', function () {

    // Must have struk session
    abort_unless(session()->has('struk'), 404);

    return view('warga.struk');

})->name('iuran.struk');

Route::post('/iuran/bayar', [IuranController::class, 'bayar'])
        ->name('iuran.bayar');

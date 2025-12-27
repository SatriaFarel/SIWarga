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

Route::get('/warga/dashboard', [WargaController::class, 'dashboard'])
    ->name('warga.dashboard');


Route::get('/warga/login', [WargaLoginController::class, 'showLogin'])
    ->name('warga.login');

Route::post('/warga/login', [WargaLoginController::class, 'login'])
    ->name('warga.login.process');

Route::post('/warga/logout', [WargaLoginController::class, 'logout'])
    ->name('warga.logout');
Route::get('/warga/struk', function () {
    abort_unless(session()->has('struk'), 404);
    return view('warga.struk');
})->name('iuran.struk');
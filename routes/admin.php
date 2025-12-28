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
    ArsipController
};

/*
|--------------------------------------------------------------------------
| ADMIN AREA (AUTH)
|--------------------------------------------------------------------------
| SEMUA route /admin WAJIB login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    Route::resource('warga', WargaController::class);

    Route::resource('artikel', ArtikelController::class)
        ->except(['show']);

    Route::resource('agenda', AgendaController::class)
        ->except(['show']);

    Route::resource('informasi', InformasiController::class)
        ->except(['show']);

    Route::resource('arsip', ArsipController::class);

    Route::resource('iuran', IuranController::class)
        ->except(['create']);

    Route::post('/iuran/bayar', [IuranController::class, 'bayar'])
        ->name('iuran.bayar');

    // Pesan warga (ADMIN)
    Route::get('/pesan', [HomeController::class, 'view'])
        ->name('pesan');

    Route::delete('/pesan/{pesan}', [HomeController::class, 'destroy'])
        ->name('pesan.destroy');

    // Iuran admin actions
    Route::get('/iuran/{id}/bukti', [IuranController::class, 'showB'])
        ->name('admin.iuran.showB');

    Route::post('/iuran/{id}/acc', [IuranController::class, 'acc'])
        ->name('admin.iuran.acc');

    Route::post('/iuran/{id}/tolak', [IuranController::class, 'tolak'])
        ->name('admin.iuran.tolak');

    Route::post('/iuran/manual/{iuran}', [IuranController::class, 'bayarManual'])
        ->name('admin.iuran.manual');

    Route::get('/laporan-iuran', [IuranController::class, 'laporan'])
        ->name('laporan.iuran');

    Route::get('/laporan-iuran/print', [IuranController::class, 'print'])
        ->name('laporan.print');
});


/*
|--------------------------------------------------------------------------
| PUBLIK AREA
|--------------------------------------------------------------------------
| YANG MEMANG DARI AWAL PUBLIK
|--------------------------------------------------------------------------
*/

// Pesan warga (kirim)
Route::post('/pesan', [HomeController::class, 'store'])
    ->name('pesan.store');

// Artikel publik
Route::get('/artikel', [ArtikelController::class, 'viewAllArtikel'])
    ->name('artikel.all');

Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])
    ->name('artikel.show');

Route::post('/artikel/gambar/upload', [ArtikelController::class, 'uploadGambar'])
    ->name('artikel.gambar.upload');

Route::delete('/artikel/gambar/hapus', [ArtikelController::class, 'hapusGambar'])
    ->name('artikel.gambar.hapus');

// Agenda publik
Route::get('/agenda', [AgendaController::class, 'viewAllAgenda'])
    ->name('agenda.all');

// Informasi publik
Route::get('/informasi', [InformasiController::class, 'viewAllInformasi'])
    ->name('informasi.all');

// Arsip publik
Route::get('/arsip/{arsip}/download', [ArsipController::class, 'download'])
    ->name('arsip.download');

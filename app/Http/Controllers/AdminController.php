<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Agenda;
use App\Models\Artikel;
use App\Models\Informasi;
use Illuminate\Support\Carbon;
use App\Services\IuranService;

class AdminController extends Controller
{
    // WargaController.php
    public function index()
    {
        IuranService::generateBulanan();

        // PROFIL RT MANUAL (HARDCODE)
        $profilRT = [
            'ketua_rt'  => 'Budi Santoso',
            'periode'   => '2023 - 2028',
            'jumlah_kk' => 200,
            'kontak'    => '0812-3456-7890',
        ];

        return view('admin.dashboard', [
            'warga' => Warga::count(),
            'artikel' => Artikel::count(),
            'pengumumanList' => null,
            'informasi' =>  Informasi::latest()->first(),
            // Artikel terbaru
            'artikelTerbaru' => Artikel::latest()->take(5)->get(),
            'profilRT' => $profilRT,
            // Agenda terdekat
            'agendaTerdekat' => Agenda::where('Tanggal_Mulai', '>=', now())
                                      ->orderBy('Tanggal_Mulai', 'asc')
                                      ->take(5)
                                      ->get(),
        ]);
    }
}

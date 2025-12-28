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
    /**
     * Admin Dashboard Controller
     *
     * Handle main data for admin dashboard (SIWarga).
     * Only prepare data, no heavy business logic here.
     */
    public function index()
    {
        /**
         * Auto generate monthly iuran
         * Called when admin opens dashboard
         * (ensure iuran data always up to date)
         */
        IuranService::generateBulanan();

        /**
         * RT Profile (temporary hardcode)
         * Later can be moved to database or config
         */
        $profilRT = [
            'ketua_rt'  => 'Budi Santoso',
            'periode'   => '2023 - 2028',

            'alamat_rt' => 'Jl. Mawar RT 01 RW 05, Pulo Gebang',
            'kelurahan' => 'Pulo Gebang',
            'kecamatan' => 'Cakung',
            'kota'      => 'Jakarta Timur',
        ];

        /**
         * Send all required data to dashboard view
         */
        return view('admin.dashboard', [

            // Total warga count
            'warga' => Warga::count(),

            // Total artikel count
            'artikel' => Artikel::count(),

            // Placeholder (future feature)
            'pengumumanList' => null,

            // Latest information / announcement
            'informasi' => Informasi::latest()->first(),

            // Latest 5 articles
            'artikelTerbaru' => Artikel::latest()
                                       ->take(5)
                                       ->get(),

            // RT profile data
            'profilRT' => $profilRT,

            // Nearest upcoming agenda (max 5)
            'agendaTerdekat' => Agenda::where('Tanggal_Mulai', '>=', now())
                                       ->orderBy('Tanggal_Mulai', 'asc')
                                       ->take(5)
                                       ->get(),
        ]);
    }
}

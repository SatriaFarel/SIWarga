<?php

namespace App\Services;

use App\Models\Warga;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IuranService
{
    public static function generateBulanan()
    {
        // Patokan: tanggal 1 bulan ini
        $tanggalBulanIni = Carbon::now()->startOfMonth(); // YYYY-MM-01

        $wargaList = Warga::all();

        foreach ($wargaList as $warga) {

            $sudahAda = DB::table('iuran')
                ->where('Id_Warga', $warga->id)
                ->where('Tanggal_Bayar', $tanggalBulanIni->toDateString())
                ->exists();


            if (!$sudahAda) {
                DB::table('iuran')->insert([
                    'Id_Warga'       => $warga->id,
                    'Tanggal_Bayar'  => $tanggalBulanIni, // FIX di sini
                    'Status'         => 'Belum Bayar', // atau 'pending' sesuai sistem lo
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        return true;
    }
}

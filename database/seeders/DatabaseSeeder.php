<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // USER (ADMIN)
        // =========================
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('123'),
        ]);

        // =========================
        // WARGA
        // =========================
        DB::table('warga')->insert([
            'NIK'           => '3170000000000001',
            'No_KK'         => '3170000000000000',
            'Password'      => Hash::make('123'),
            'Nama'          => 'Budi Santoso',
            'Jenis_Kelamin' => 'Laki Laki',
            'Alamat'        => 'Jl. Mawar RT 01 RW 02',
            'No_HP'         => '081234567890',
            'Tanggal_Lahir' => '2004-08-10',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // =========================
        // ARTIKEL (gambar nullable)
        // =========================
        DB::table('artikel')->insert([
            'Judul'      => 'Kerja Bakti Warga',
            'Slug'       => 'kerja-bakti-warga',
            'Konten'     => 'Kerja bakti rutin dilaksanakan setiap hari Minggu.',
            'Thumbnail'  => 'assets/artikel/1766611111-banksampah.webp',
            'Penulis'    => 'Admin RT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =========================
        // INFORMASI
        // =========================
        DB::table('informasi')->insert([
            'Judul'       => 'Pemberitahuan Iuran',
            'Ringkasan'   => 'Iuran bulanan warga',
            'Isi'         => 'Iuran wajib dibayarkan sebelum tanggal 10.',
            'Is_penting' => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // =========================
        // AGENDA (gambar nullable)
        // =========================
        DB::table('agenda')->insert([
            'Judul'           => 'Rapat Warga',
            'Deskripsi'       => 'Rapat evaluasi kegiatan RT',
            'Tanggal_Mulai'   => '2025-01-15',
            'Tanggal_Selesai' => '2025-01-15',
            'Lokasi'          => 'Balai RT',
            'Gambar'          => 'assets/agenda/RapatRT.webp',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // =========================
        // PESAN LAPORAN
        // =========================
        DB::table('pesan_laporan')->insert([
            'Nama'       => 'Budi Santoso',
            'Email'      => 'budi@gmail.com',
            'Jenis'      => 'Laporan',
            'Pesan'      => 'Lampu jalan di RT 01 sudah mati sejak 3 hari.',
            'Status'     => 'Baru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * This seeder inserts initial / dummy data
     * for development and testing purpose.
     */
    public function run(): void
    {
        // =========================
        // USERS (ADMIN & SUPER ADMIN)
        // =========================
        // Insert default admin accounts
        DB::table('users')->insert([
            [
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'role'     => 'super_admin',
                // Password is hashed for security
                'password' => Hash::make('123'),
            ],
            [
                'name'     => 'agus',
                'email'    => 'agus@gmail.com',
                'role'     => 'admin',
                'password' => Hash::make('123'),
            ],
        ]);

        // =========================
        // WARGA (RESIDENT DATA)
        // =========================
        // Insert sample resident data
        DB::table('warga')->insert([
            'NIK'           => '3170000000000001', // 16-digit national ID
            'No_KK'         => '3170000000000000', // Family card number
            'Password'      => Hash::make('123'), // Login password
            'Nama'          => 'Budi Santoso',
            'Jenis_Kelamin' => 'Laki Laki',
            'Alamat'        => 'Jl. Mawar RT 01 RW 02',
            'No_HP'         => '081234567890',
            'Tanggal_Lahir' => '2004-08-10',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // =========================
        // ARTIKEL
        // =========================
        // Thumbnail is nullable
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
        // INFORMASI / ANNOUNCEMENT
        // =========================
        // Important information for residents
        DB::table('informasi')->insert([
            'Judul'       => 'Pemberitahuan Iuran',
            'Ringkasan'   => 'Iuran bulanan warga',
            'Isi'         => 'Iuran wajib dibayarkan sebelum tanggal 10.',
            'Is_penting' => 1, // Mark as important
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =========================
        // AGENDA
        // =========================
        // Agenda image is optional
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
        // Sample report message from resident
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesan_laporan', function (Blueprint $table) {
            $table->id();

            // Nama pengirim (opsional)
            $table->string('Nama')->nullable();

            // Email pengirim
            $table->string('Email');

            // Jenis pesan
            $table->enum('Jenis', ['Laporan', 'Saran', 'Kritik']);

            // Isi pesan
            $table->text('Pesan');

            // Status pesan (untuk admin)
            $table->enum('Status', ['Baru', 'Dibaca', 'Ditindaklanjuti'])->default('baru');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_laporan');
    }
};

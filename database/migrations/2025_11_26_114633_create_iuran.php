<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Id_Warga')->constrained('warga')->cascadeOnDelete();
            $table->date('Tanggal_Bayar');
            $table->enum('Status', ['Lunas', 'Belum Bayar', 'Menunggu Konfirmasi'])->default('Belum Bayar');
            $table->string('Bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

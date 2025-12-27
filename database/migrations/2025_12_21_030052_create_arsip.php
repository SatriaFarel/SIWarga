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
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->enum('kategori', [
                'undangan',
                'edaran',
                'laporan',
                'sk',
                'lainnya'
            ]);

            $table->string('nama_file');      // nama asli file
            $table->string('path_file');      // storage path
            $table->string('tipe_file', 10);  // pdf / doc / docx
            $table->integer('ukuran_file');   // dalam KB

            $table->date('tanggal_dokumen');

            $table->enum('akses', ['admin', 'publik'])
                ->default('admin');

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};

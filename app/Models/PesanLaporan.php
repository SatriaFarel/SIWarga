<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanLaporan extends Model
{
    use HasFactory;

    protected $table = 'pesan_laporan';

    protected $fillable = [
        'Nama',
        'Email',
        'Jenis',
        'Pesan',
        'Status',
    ];
}

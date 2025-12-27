<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{

    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
        'judul',
        'kategori',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
        'tanggal_dokumen',
        'akses',
        'uploaded_by'
    
    ];
}

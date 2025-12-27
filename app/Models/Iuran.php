<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{

    use HasFactory;

    protected $table = 'iuran';

    protected $fillable = [
        'id',
        'Id_Warga', 
        'Tanggal_Bayar', 
        'Status', 
        'Bukti'
    ];
}

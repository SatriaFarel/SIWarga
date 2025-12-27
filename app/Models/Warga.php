<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $fillable = [
        'NIK',
        'No_KK',
        'Password',
        'Nama',
        'Jenis_Kelamin',
        'Alamat',
        'No_HP',
        'Tanggal_Lahir',
    ];
}

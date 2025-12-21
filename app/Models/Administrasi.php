<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrasi extends Model
{
    use HasFactory;

    // Arahkan ke nama tabel yang benar (karena defaultnya Laravel nyari 'administrasis')
    protected $table = 'administrasi';

    // Izinkan field ini diisi secara massal (create/update)
    protected $fillable = [
        'slug',
        'kategori',
        'nama',
        'deskripsi',
        'prosedur',
        'syarat',
    ];

    // INI YANG PENTING BRO: Casting JSON ke Array
    protected $casts = [
        'prosedur' => 'array',
        'syarat'   => 'array',
    ];
}

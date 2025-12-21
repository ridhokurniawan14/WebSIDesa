<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bumdes extends Model
{
    // Nama tabel (eksplisit biar aman)
    protected $table = 'bumdes';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama',
        'slogan',
        'tentang',
        'visi',
        'misi',
        'unit_usaha',
        'pengurus',
        'kontak',
    ];

    // Magic-nya Laravel: Convert JSON <-> Array otomatis
    protected $casts = [
        'misi' => 'array',
        'unit_usaha' => 'array',
        'pengurus' => 'array',
        'kontak' => 'array',
    ];
}

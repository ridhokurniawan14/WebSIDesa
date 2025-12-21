<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kdmp extends Model
{
    // Arahkan model ke tabel yang benar
    protected $table = 'koperasidesa';

    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'nama_koperasi',
        'deskripsi',
        'struktur_pengurus',
        'syarat_anggota',
        'contact_person',
    ];

    // Otomatis ubah JSON di database jadi Array di PHP
    protected $casts = [
        'struktur_pengurus' => 'array',
        'syarat_anggota' => 'array',
    ];
}

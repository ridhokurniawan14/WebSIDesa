<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KarangTaruna extends Model
{
    // Nama tabel (optional jika sesuai standar, tapi baik didefinisikan biar jelas)
    protected $table = 'karang_tarunas';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama',
        'deskripsi',
        'visi',
        'misi',
        'program',
        'galeri',
        'pengurus',
        'kontak',
    ];

    // INI YANG PENTING BRO:
    // Mengubah data JSON di DB menjadi Array PHP secara otomatis saat diambil
    protected $casts = [
        'misi' => 'array',
        'program' => 'array',
        'galeri' => 'array',
        'pengurus' => 'array',
        'kontak' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use HasFactory;

    // Definisikan nama tabel karena migrasi menggunakan singular 'beranda'
    protected $table = 'beranda';

    protected $fillable = [
        'banner_images',
        'deskripsi',
        'sambutan_kades',
        'periode_jabatan',
        'total_penduduk',
        'total_laki_laki',
        'total_perempuan',
        'usia_muda',
        'usia_dewasa',
        'usia_lansia',
        'jumlah_kk',
        'jumlah_rt',
        'jumlah_rw',
        'jumlah_dusun',
        'desa_adat',
        'keluarga_miskin',
        'nama_kepala_desa',
        'foto_kepala_desa'
    ];

    // Casting JSON ke Array otomatis
    protected $casts = [
        'banner_images' => 'array',
    ];
}

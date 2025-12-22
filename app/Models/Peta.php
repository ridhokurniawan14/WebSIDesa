<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peta extends Model
{
    // Pastikan nama tabel sesuai dengan migration tadi
    protected $table = 'peta';

    // Daftar kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'batas_utara',
        'batas_timur',
        'batas_selatan',
        'batas_barat',
        'luas_wilayah',
        'koordinat_kantor',
        'polygon_wilayah',
        'zoom_level',
    ];

    // Konversi tipe data otomatis
    protected $casts = [
        // 'array' akan mengubah JSON dari DB menjadi Array PHP secara otomatis
        'polygon_wilayah' => 'array',

        // Memastikan luas wilayah dianggap angka (bukan string)
        'luas_wilayah' => 'decimal:2',

        // Zoom level pasti integer
        'zoom_level' => 'integer',
    ];
}

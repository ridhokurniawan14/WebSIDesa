<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkk extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit karena di migration tadi pakai 'pkk' (singular)
    protected $table = 'pkk';

    protected $fillable = [
        'nama_ketua',
        'nomor_hp_wa',
        'gambar_ilustrasi',
        'pengurus',       // Disimpan sebagai JSON
        'kegiatan',       // Disimpan sebagai JSON
        'program_pokok',  // Disimpan sebagai JSON
    ];

    /**
     * Casting otomatis kolom JSON menjadi Array PHP.
     * Sangat penting agar di blade bisa langsung loop (foreach).
     */
    protected $casts = [
        'pengurus' => 'array',
        'kegiatan' => 'array',
        'program_pokok' => 'array',
    ];
}

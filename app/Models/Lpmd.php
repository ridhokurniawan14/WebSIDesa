<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpmd extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit (opsional, tapi aman)
    protected $table = 'lpmd';

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'deskripsi',
        'dasar_hukum',
        'tugas_fungsi',
        'struktur_gambar',
        'ketua',
        'sekretaris',
        'bendahara',
        'bidang',
        'program',
    ];

    // Magic-nya di sini: Database simpan JSON, tapi pas dipanggil jadi Array
    protected $casts = [
        'dasar_hukum' => 'array',
        'tugas_fungsi' => 'array',
        'bidang' => 'array',
        'program' => 'array',
    ];
}

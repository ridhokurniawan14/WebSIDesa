<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel secara eksplisit
    // Karena default Laravel akan mencari tabel 'perangkats', sedangkan kita buatnya 'perangkat_desa'
    protected $table = 'perangkat_desa';

    // 2. Izinkan kolom ini diisi (Mass Assignment)
    protected $fillable = [
        'foto_struktur_organisasi',
        'data_perangkat',
    ];

    // 3. Casting JSON (PENTING!)
    // Ini biar pas diambil dari DB, 'data_perangkat' otomatis jadi Array PHP.
    // Jadi bro Ridho gak perlu ribet pakai json_decode() atau json_encode() manual lagi.
    protected $casts = [
        'data_perangkat' => 'array',
    ];
}

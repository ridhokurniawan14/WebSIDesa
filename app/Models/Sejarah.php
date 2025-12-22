<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sejarah extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit (jaga-jaga biar gak dicari 'sejarahs')
    protected $table = 'sejarah';

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'foto',
        'asal_usul',
        'timeline',
    ];

    // Konversi otomatis kolom 'timeline' dari JSON ke Array
    // Jadi nanti saat coding di Controller/View gak perlu json_decode manual lagi bro
    protected $casts = [
        'timeline' => 'array',
    ];
}

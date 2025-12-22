<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel (karena di migration tadi namanya 'visimisi', bukan 'visi_misis')
    protected $table = 'visimisi';

    // 2. Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'visi',
        'misi',
    ];

    // 3. Casting kolom 'misi' agar otomatis dibaca sebagai Array oleh PHP
    protected $casts = [
        'misi' => 'array',
    ];
}

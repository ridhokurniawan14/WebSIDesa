<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukHukum extends Model
{
    use HasFactory;

    // Definisikan nama tabel biar gak salah baca (karena defaultnya 'produk_hukums')
    protected $table = 'produk_hukum';

    // Field yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'judul',
        'jenis',
        'tahun',
        'file',
    ];
}

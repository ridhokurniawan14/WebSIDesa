<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai standar plural, tapi aman didefinisikan)
    protected $table = 'beritas';

    // Kolom yang diizinkan untuk diisi secara massal (Create/Update)
    protected $fillable = [
        'slug',
        'title',
        'date',
        'thumbnail',
        'excerpt',
        'content',
    ];

    // Mengubah tipe data 'date' menjadi instance Carbon
    // Jadi nanti bisa langsung pakai format: $berita->date->format('d M Y')
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Opsional: Jika nanti mau routing pakai slug (misal: /berita/judul-berita)
     * alih-alih pakai ID. Hapus function ini jika tetap mau pakai ID.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

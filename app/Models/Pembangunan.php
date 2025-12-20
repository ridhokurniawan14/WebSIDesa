<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembangunan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Wajib didefinisikan karena nama tabelmu 'pembangunan' (singular),
     * sedangkan default Laravel mencari yang plural ('pembangunans').
     */
    protected $table = 'pembangunan';

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment).
     * Sesuai dengan field di migration tadi.
     */
    protected $fillable = [
        'slug',
        'judul',
        'desa',
        'lokasi',
        'volume',
        'anggaran',
        'sumber_dana',
        'tahun',
        'pelaksana',
        'status',
        'keterangan',
        'foto',
    ];

    /**
     * Attribute Casting.
     * Ini BAGIAN PENTINGNYA bro.
     * Kita kasih tahu Laravel bahwa kolom 'foto' itu tipe JSON,
     * jadi saat diambil (get), otomatis diubah jadi Array PHP.
     * Saat disimpan (set), otomatis diubah jadi JSON string.
     */
    protected $casts = [
        'foto' => 'array',
        'anggaran' => 'integer', // Opsional, biar pasti angka
    ];
}

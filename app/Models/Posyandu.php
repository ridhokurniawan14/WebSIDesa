<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika mengikuti konvensi, tapi bagus untuk kejelasan)
    protected $table = 'posyandus';

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'deskripsi',
        'tujuan',
        'layanan',
        'sasaran',
        'jadwal',
        'gambar_struktur',
        'nama_ketua',
        'nama_sekretaris',
        'nama_bendahara',
        'nama_kader',
        'program',
        'kontak',
    ];

    // Konversi otomatis JSON di database menjadi Array di PHP
    protected $casts = [
        'tujuan' => 'array',
        'layanan' => 'array',
        'sasaran' => 'array',
        'nama_kader' => 'array',
        'program' => 'array',
        'kontak' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (jaga-jaga agar Laravel tidak bingung plural-nya)
    protected $table = 'apbdes';

    // Field yang boleh diisi via form (Mass Assignment)
    // Sesuai dengan migration yang kita bahas sebelumnya
    protected $fillable = [
        'tahun',
        'jenis',      // 'pendapatan', 'belanja', 'pembiayaan'
        'uraian',     // Nama item
        'anggaran',
        'realisasi',
    ];

    // Casting tipe data untuk memastikan angka terbaca sebagai integer, bukan string
    protected $casts = [
        'tahun' => 'integer',
        'anggaran' => 'integer',
        'realisasi' => 'integer',
    ];

    /**
     * ACCESSOR: Menghitung persentase capaian secara otomatis.
     * Cara panggil di blade/controller: $item->persen_capaian
     */
    public function getPersenCapaianAttribute()
    {
        if ($this->anggaran <= 0) {
            return 0;
        }

        return round(($this->realisasi / $this->anggaran) * 100, 2);
    }

    /**
     * ACCESSOR: Menghitung sisa anggaran (Selisih).
     * Cara panggil: $item->sisa_anggaran
     */
    public function getSisaAnggaranAttribute()
    {
        return $this->anggaran - $this->realisasi;
    }
}

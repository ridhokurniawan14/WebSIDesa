<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    use HasFactory;

    protected $table = 'apbdes';

    protected $fillable = [
        'tahun',
        'jenis',      // 'pendapatan', 'belanja', 'pembiayaan'
        'uraian',     // Nama item
        'anggaran',
        'realisasi',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'anggaran' => 'decimal:2',
        'realisasi' => 'decimal:2',
    ];

    public function getPersenCapaianAttribute()
    {
        if ($this->anggaran <= 0) {
            return 0;
        }

        return round(($this->realisasi / $this->anggaran) * 100, 2);
    }

    public function getSisaAnggaranAttribute()
    {
        return $this->anggaran - $this->realisasi;
    }
}

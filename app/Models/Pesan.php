<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_hp',
        'subject',
        'isi_pesan',
    ];
}

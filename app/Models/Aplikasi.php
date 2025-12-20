<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    protected $fillable = [
        'logo',
        'nama_desa',
        'kabupaten',
        'nama_kantor',
        'alamat',
        'telepon',
        'email',
        'wa_cs',
        'jam_operasional',
        'facebook',
        'instagram',
        'youtube',
        'whatsapp',
        'footer',
        'map'
    ];
}

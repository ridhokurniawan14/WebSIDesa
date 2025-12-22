<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'method',
        'referer',
        'user_id',
    ];

    // Opsional: Relasi ke User jika ada
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

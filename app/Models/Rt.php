<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rt extends Model
{
    protected $guarded = ['id'];

    // Relasi: Satu RT dimiliki oleh satu RW
    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }
}

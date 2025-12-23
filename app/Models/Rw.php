<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rw extends Model
{
    // Kita pakai guarded kosong biar bisa mass assignment (create data langsung banyak field)
    protected $guarded = ['id'];

    // Relasi: Satu RW memiliki banyak RT
    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }
}

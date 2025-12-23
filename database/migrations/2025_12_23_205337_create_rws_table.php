<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rws', function (Blueprint $table) {
            $table->id();
            // Kita pakai ENUM agar datanya konsisten sesuai request
            $table->enum('dusun', [
                'Krajan Satu',
                'Krajan Dua',
                'Kaliputih',
                'Temurejo',
                'Pandan',
                'Cendono',
                'Ringinsari'
            ]);
            $table->string('nomor_rw'); // Pakai string biar bisa input '01', '02' (ada nol di depan)
            $table->string('nama_ketua_rw')->nullable(); // Bisa dikosongi dulu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rws');
    }
};

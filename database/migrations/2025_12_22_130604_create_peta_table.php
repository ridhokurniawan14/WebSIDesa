<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peta', function (Blueprint $table) {
            $table->id();

            // 1. Batas Desa (String biasa)
            $table->string('batas_utara')->nullable();
            $table->string('batas_timur')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_barat')->nullable();

            // 2. Luas Wilayah (Decimal agar presisi meter perseginya)
            // 15 digit total, 2 digit di belakang koma
            $table->decimal('luas_wilayah', 15, 2)->default(0)->comment('Dalam meter persegi');

            // 3. Koordinat (Solusi Praktis: JSON)

            // Untuk titik tengah maps / marker kantor desa (disimpan format lat,lng)
            $table->string('koordinat_kantor')->nullable()->comment('Lat,Long contoh: -8.36770, 114.18542');

            // Untuk Polygon Wilayah (Array of arrays yang panjang)
            // Kita pakai JSON agar bisa menampung format array JS: [[lat,lng], [lat,lng], ...]
            $table->json('polygon_wilayah')->nullable()->comment('Array koordinat polygon');

            // Optional: Zoom level default (biar admin bisa atur zoom awal)
            $table->integer('zoom_level')->default(15);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peta');
    }
};

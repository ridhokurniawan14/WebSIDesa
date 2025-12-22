<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sejarah', function (Blueprint $table) {
            $table->id();

            // 1. Upload foto sejarah (disimpan path-nya string)
            // Saya set nullable jaga-jaga kalau admin belum punya foto saat input awal
            $table->string('foto')->nullable();

            // 2. Asal usul desa (Teks panjang)
            // Menggunakan longText biar muat banyak paragraf cerita desa
            $table->longText('asal_usul');

            // 3. Timeline (JSON)
            // Isinya nanti array object: [{ "tahun": "...", "judul": "...", "ket": "..." }]
            $table->json('timeline')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sejarah');
    }
};

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
        Schema::create('lpmd', function (Blueprint $table) {
            $table->id();

            // 1. Deskripsi (Text panjang)
            $table->text('deskripsi')->nullable();

            // 2. Dasar Hukum (Disimpan sebagai Array/JSON)
            $table->json('dasar_hukum')->nullable();

            // 3. Tugas & Fungsi (Disimpan sebagai Array/JSON)
            $table->json('tugas_fungsi')->nullable();

            // 4. Struktur Organisasi
            // Kita pecah struktur intinya menjadi kolom biasa agar mudah diedit
            $table->string('struktur_gambar')->nullable(); // path gambar
            $table->string('ketua')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();

            // Untuk 'bidang', karena dinamis (bisa nambah/kurang), kita pakai JSON
            $table->json('bidang')->nullable();

            // 5. Program (Disimpan sebagai Array/JSON)
            $table->json('program')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpmd');
    }
};

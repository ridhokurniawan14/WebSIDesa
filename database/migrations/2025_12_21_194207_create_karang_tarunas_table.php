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
        Schema::create('karang_tarunas', function (Blueprint $table) {
            $table->id();

            // Data Utama (String/Text biasa)
            $table->string('nama'); // Karang Taruna Desa Maju Jaya
            $table->text('deskripsi');
            $table->text('visi');

            // Data Array/List (Disimpan sebagai JSON)
            // Ini kuncinya biar tetap 1 tabel bro
            $table->json('misi')->nullable();     // Array simple
            $table->json('program')->nullable();  // Array of objects (judul, deskripsi, icon)
            $table->json('galeri')->nullable();   // Array of objects (judul, gambar)
            $table->json('pengurus')->nullable(); // Array of objects (jabatan, nama, gambar)
            $table->json('kontak')->nullable();   // Object (wa, email, ig)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karang_tarunas');
    }
};

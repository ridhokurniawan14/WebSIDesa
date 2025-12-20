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
        Schema::create('posyandus', function (Blueprint $table) {
            $table->id();

            // 1. Bagian Deskripsi Utama
            $table->text('deskripsi'); // Menggunakan text karena isinya panjang

            // 2. Bagian List (Array sederhana)
            // Kita gunakan tipe JSON agar bisa menyimpan array ['A', 'B', 'C'] langsung
            $table->json('tujuan')->nullable();
            $table->json('layanan')->nullable();
            $table->json('sasaran')->nullable();

            // 3. Bagian Jadwal
            $table->string('jadwal')->nullable(); // Contoh: "Setiap tanggal 10..."

            // 4. Bagian Struktur Organisasi
            // Saya pecah role inti menjadi kolom sendiri agar mudah di-input di Admin Panel,
            // sedangkan kader (yang jumlahnya banyak) masuk ke JSON.
            $table->string('gambar_struktur')->nullable(); // Path gambar
            $table->string('nama_ketua')->nullable();
            $table->string('nama_sekretaris')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->json('nama_kader')->nullable(); // List nama kader

            // 5. Bagian Program
            $table->json('program')->nullable(); // List program

            // 6. Bagian Kontak
            // Karena kontak isinya array of object (nama, jabatan, telepon),
            // paling tepat menggunakan JSON untuk menampungnya.
            $table->json('kontak')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandus');
    }
};

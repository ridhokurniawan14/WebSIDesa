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
        Schema::create('koperasidesa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koperasi');
            $table->text('deskripsi'); // Pakai text biar muat panjang

            // Menyimpan array object: [{foto, nama, jabatan}, ...]
            $table->json('struktur_pengurus')->nullable();

            // Menyimpan array string: ["Syarat 1", "Syarat 2", ...]
            $table->json('syarat_anggota')->nullable();

            $table->string('contact_person'); // Bisa diisi nomor WA/Telp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasidesa');
    }
};

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
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();

            // 1. Kolom untuk upload foto bagan/struktur organisasi (path file)
            // Dibuat nullable jaga-jaga kalau admin belum upload fotonya
            $table->string('foto_struktur_organisasi')->nullable();

            // 2. Kolom JSON untuk menampung array data pegawai (seperti contoh statis bro Ridho)
            $table->json('data_perangkat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_desa');
    }
};

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
        Schema::create('pkk', function (Blueprint $table) {
            $table->id();

            // 1. Data Statis (Single Value)
            $table->string('nama_ketua')->nullable();        // Request: Nama Ketua
            $table->string('nomor_hp_wa')->nullable();       // Request: Nomor HP WA
            $table->string('gambar_ilustrasi')->nullable();  // Request: Upload gambar ilustrasi

            // 2. Data List/Array (Disimpan sebagai JSON)
            // Kolom ini akan menampung array of objects dari $pengurus (jabatan, nama, foto)
            $table->json('pengurus')->nullable();

            // Kolom ini menampung array string dari $kegiatan
            $table->json('kegiatan')->nullable();

            // Kolom ini menampung array string dari $program_pokok
            $table->json('program_pokok')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkk');
    }
};

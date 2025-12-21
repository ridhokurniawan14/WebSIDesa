<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bumdes', function (Blueprint $table) {
            $table->id();

            // --- DATA UTAMA ---
            $table->string('nama');
            $table->string('slogan')->nullable();
            $table->text('tentang');
            $table->text('visi');

            // --- DATA LIST (JSON) ---
            // Disimpan sebagai JSON Array ["Misi 1", "Misi 2"]
            $table->json('misi')->nullable();

            // Disimpan sebagai JSON Array of Objects 
            // [{"nama": "Simpan Pinjam", "deskripsi": "..."}]
            $table->json('unit_usaha')->nullable();

            // --- PENGURUS (JSON vs FIELD) ---
            // Opsi 1: JSON (sesuai struktur array controller kamu)
            // {"direktur": "Budi", "sekretaris": "Siti", "bendahara": "Ahmad"}
            $table->json('pengurus')->nullable();

            // --- KONTAK (JSON) ---
            // {"alamat": "...", "telepon": "...", "email": "..."}
            $table->json('kontak')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bumdes');
    }
};

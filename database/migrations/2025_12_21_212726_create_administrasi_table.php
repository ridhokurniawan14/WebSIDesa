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
        Schema::create('administrasi', function (Blueprint $table) {
            $table->id(); // Auto increment ID

            // Menggantikan 'id' string di array (cth: 'kk', 'ktp')
            // Kita pakai nama 'slug' biar unik dan SEO friendly buat URL nanti
            $table->string('slug')->unique();

            // Kategori (cth: 'kependudukan', 'surat-keterangan')
            $table->string('kategori');

            // Nama Layanan
            $table->string('nama');

            // Deskripsi singkat
            $table->text('deskripsi')->nullable();

            // JSON untuk menampung array langkah-langkah
            $table->json('prosedur')->nullable();

            // JSON untuk menampung array persyaratan
            $table->json('syarat')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasi');
    }
};

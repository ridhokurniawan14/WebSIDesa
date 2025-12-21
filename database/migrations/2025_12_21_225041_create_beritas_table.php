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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();

            // Kolom sesuai data di controller
            $table->string('slug')->unique(); // Wajib unique buat URL
            $table->string('title');
            $table->date('date'); // Ubah string '12 Jan 2025' jadi tipe Date biar bisa di-sort DB
            $table->string('thumbnail')->nullable(); // Nullable jaga-jaga kalau gak ada gambar
            $table->text('excerpt')->nullable(); // Ringkasan berita
            $table->longText('content'); // Pakai longText karena isinya HTML panjang

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};

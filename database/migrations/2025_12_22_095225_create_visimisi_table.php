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
        Schema::create('visimisi', function (Blueprint $table) {
            $table->id();
            $table->text('visi'); // Pakai text agar bisa menampung kalimat panjang
            $table->json('misi'); // Pakai json sesuai request (untuk array misi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visimisi');
    }
};

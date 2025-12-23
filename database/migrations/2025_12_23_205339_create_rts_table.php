<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel rws. cascadeOnDelete artinya kalau RW dihapus, RT-nya ikut terhapus (biar bersih)
            $table->foreignId('rw_id')->constrained('rws')->cascadeOnDelete();

            $table->string('nomor_rt'); // Pakai string, contoh: '05'
            $table->string('nama_ketua_rt')->nullable();

            // Opsional: Untuk mencegah input ganda (RT 01 di RW yang sama tidak boleh ada 2)
            $table->unique(['rw_id', 'nomor_rt']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembangunan', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('slug')->unique();
            $table->string('judul');
            $table->string('desa');
            $table->string('lokasi');

            // Teknis
            $table->string('volume');
            $table->bigInteger('anggaran');
            $table->string('sumber_dana');
            $table->char('tahun', 4);
            $table->string('pelaksana');

            // Status
            $table->string('status')->default('Proses');
            $table->text('keterangan')->nullable();

            // MEDIA (Cukup 1 kolom ini saja)
            // Tipe JSON bisa menampung array: ["foto1.jpg", "foto2.jpg", "foto3.jpg"]
            $table->json('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembangunan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            // Menyimpan Tahun Anggaran (misal: 2024, 2025)
            $table->year('tahun')->index();

            // Pengelompokan Data (Penting untuk memisah Pendapatan vs Belanja di View)
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan']);

            // Nama Item (Misal: "Dana Desa", "Bidang Pembangunan", dll)
            $table->string('uraian');

            // Nominal Anggaran (Gunakan BigInteger untuk angka uang agar aman)
            $table->bigInteger('anggaran')->default(0);

            // Nominal Realisasi (Apa yang sudah terpakai/terima)
            $table->bigInteger('realisasi')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apbdes');
    }
};

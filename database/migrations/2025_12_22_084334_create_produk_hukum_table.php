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
        Schema::create('produk_hukum', function (Blueprint $table) {
            $table->id();

            // Field Judul
            $table->string('judul');

            // Field Jenis (Dibuat Enum agar sesuai 4 kategori statis permintaanmu)
            $table->enum('jenis', [
                'Peraturan Desa',
                'Peraturan Kepala Desa',
                'Keputusan Kepala Desa',
                'Surat Edaran'
            ]);

            // Field Tahun (Pakai tipe year biar pas formatnya)
            $table->year('tahun');

            // Field File (Untuk menyimpan path/nama file PDF)
            $table->string('file');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_hukum');
    }
};

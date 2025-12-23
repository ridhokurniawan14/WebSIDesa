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
        Schema::table('beranda', function (Blueprint $table) {
            // Menambahkan kolom baru setelah sambutan_kades
            $table->string('nama_kepala_desa')->nullable()->after('sambutan_kades');
            $table->string('foto_kepala_desa')->nullable()->after('nama_kepala_desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beranda', function (Blueprint $table) {
            $table->dropColumn(['nama_kepala_desa', 'foto_kepala_desa']);
        });
    }
};

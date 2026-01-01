<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('apbdes', function (Blueprint $table) {
            // Ubah tipe data dari BIGINT ke DECIMAL(15, 2) untuk menampung desimal
            // 15 digit total, 2 digit di belakang koma (contoh: 1234567890123.45)
            $table->decimal('anggaran', 15, 2)->change();
            $table->decimal('realisasi', 15, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('apbdes', function (Blueprint $table) {
            // Kembalikan ke BIGINT jika rollback
            $table->bigInteger('anggaran')->change();
            $table->bigInteger('realisasi')->nullable()->change();
        });
    }
};

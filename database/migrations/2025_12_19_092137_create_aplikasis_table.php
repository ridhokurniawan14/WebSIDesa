<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aplikasis', function (Blueprint $table) {
            $table->id();

            $table->string('logo')->nullable();

            $table->string('nama_desa');
            $table->string('kabupaten');
            $table->string('nama_kantor');

            $table->text('alamat');
            $table->string('jam_operasional')->nullable();

            $table->string('telepon')->nullable();
            $table->string('email')->nullable();

            $table->string('wa_cs')->nullable();

            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();

            $table->text('footer')->nullable();
            $table->text('map')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aplikasis');
    }
};

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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable(); // Support IPv4 & IPv6
            $table->text('user_agent')->nullable(); // Info device/browser
            $table->string('url'); // URL yang diakses
            $table->string('method')->nullable(); // GET, POST, dll
            $table->text('referer')->nullable(); // Datang dari link mana
            $table->unsignedBigInteger('user_id')->nullable(); // Jika user login (opsional)
            $table->timestamps(); // created_at adalah waktu akses

            // Indexing biar query statistik nanti cepat
            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

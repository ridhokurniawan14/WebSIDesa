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
        Schema::create('beranda', function (Blueprint $table) {
            $table->id();

            // 1. Upload gambar banner (Array of images via JSON)
            // Nanti format simpannya: ["img1.jpg", "img2.jpg", ...]
            $table->json('banner_images')->nullable();

            // 2. Deskripsi desa
            $table->text('deskripsi')->nullable();

            // 3. Sambutan kepala desa
            $table->text('sambutan_kades')->nullable();

            // 4. Periode menjabat (String karena formatnya "2024-2029")
            $table->string('periode_jabatan')->nullable();

            // Data Statistik (Saya pakai default 0 biar rapi saat inisialisasi)
            // 5. Total Penduduk
            $table->integer('total_penduduk')->default(0);

            // 6. Banyak Laki-Laki
            $table->integer('total_laki_laki')->default(0);

            // 7. Banyak Perempuan
            $table->integer('total_perempuan')->default(0);

            // 8. Usia Muda (0-17)
            $table->integer('usia_muda')->default(0);

            // 9. Usia Dewasa (18–59)
            $table->integer('usia_dewasa')->default(0);

            // 10. Lansia (60+)
            $table->integer('usia_lansia')->default(0);

            // 11. Jumlah KK
            $table->integer('jumlah_kk')->default(0);

            // 12. Jumlah RT
            $table->integer('jumlah_rt')->default(0);

            // 13. Jumlah RW
            $table->integer('jumlah_rw')->default(0);

            // 14. Jumlah Dusun
            $table->integer('jumlah_dusun')->default(0);

            // 15. Desa Adat (Asumsi ini jumlah, jika status ya/tidak bisa ganti boolean)
            $table->integer('desa_adat')->default(0);

            // 16. Keluarga Miskin
            $table->integer('keluarga_miskin')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beranda');
    }
};

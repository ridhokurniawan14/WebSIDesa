<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Models\Aplikasi; // <--- Import Aplikasi buat Logo & Nama Desa
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosyanduController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Posyandu
        $posyandu = Posyandu::first();

        // Validasi jika data kosong
        if (!$posyandu) {
            abort(404, 'Data Posyandu belum diisi');
        }

        // 2. Ambil Data Aplikasi (Untuk Logo & Nama Desa)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 3. Logic Image (Thumbnail WA)
        // Karena tidak ada foto khusus Posyandu, kita TEMBAK LANGSUNG pakai Logo Desa.
        // Tujuannya agar saat di-share tetap ada gambarnya (official).
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 4. Logic Deskripsi
        $deskripsi = 'Informasi layanan kesehatan ibu dan anak di ' . $namaDesa;
        if (!empty($posyandu->deskripsi)) {
            $deskripsi = Str::limit(strip_tags($posyandu->deskripsi), 150);
        }

        // 5. Set SEO Helper
        // Emoji 🤱 kita taruh di TITLE biar eye-catching
        SeoHelper::set(
            title: 'Posyandu 🤱 - Website Resmi ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        return view('frontend.pages.posyandu.index', compact('posyandu'));
    }
}

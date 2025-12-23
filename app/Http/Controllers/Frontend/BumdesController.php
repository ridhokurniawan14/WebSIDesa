<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama Desa & Logo)
use App\Models\Bumdes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BumdesController extends Controller
{
    public function index()
    {
        // 1. Ambil data
        $bumdes = Bumdes::first();

        // 2. Cek jika data kosong
        if (!$bumdes) {
            return abort(404, 'Data BUMDes belum diisi di database.');
        }

        // 3. Ambil Data Aplikasi (Untuk Logo & Nama Desa)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 4. Logic Image SEO (Smart Thumbnail)
        // Prioritas: Gambar BUMDes -> Fallback: Logo Desa
        $seoImage = '';

        // Cek nama kolom gambar di DB Bumdes (misal: 'gambar' atau 'foto')
        if (!empty($bumdes->gambar)) {
            $seoImage = asset('storage/' . $bumdes->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 5. Logic Deskripsi SEO
        // Ambil cuplikan deskripsi BUMDes, bersihkan HTML, potong 150 karakter
        $deskripsiSEO = 'Profil Badan Usaha Milik Desa (BUMDes) ' . $namaDesa;

        // Asumsi nama kolomnya 'deskripsi' (sesuaikan jika namanya 'profil')
        if (!empty($bumdes->deskripsi)) {
            $deskripsiSEO = Str::limit(strip_tags($bumdes->deskripsi), 150);
        }

        // 6. Set SEO Helper
        SeoHelper::set(
            title: 'BUMDes - Website Resmi ' . $namaDesa,
            description: $deskripsiSEO,
            image: $seoImage
        );

        // 7. Return View
        // Tetap pakai toArray() sesuai request kamu agar variabel langsung pecah di View
        return view('frontend.pages.bumdes.index', $bumdes->toArray());
    }
}

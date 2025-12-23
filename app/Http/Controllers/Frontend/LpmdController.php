<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama Desa & Logo)
use App\Models\Lpmd;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <--- Import Str buat potong deskripsi

class LpmdController extends Controller
{
    public function index()
    {
        // 1. Ambil data LPMD
        $lpmd = Lpmd::first();

        // Cek jika data kosong (Sesuai kode asli kamu)
        if (!$lpmd) {
            abort(404, 'Data LPMD belum diisi oleh Admin.');
        }

        // 2. Ambil Data Aplikasi (Nama Desa & Logo)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 3. Logic Image SEO (Smart Thumbnail)
        // Prioritas: Foto Struktur LPMD -> Fallback: Logo Desa
        $seoImage = '';

        // Cek apakah tabel lpmd punya kolom 'gambar' atau 'foto' (sesuaikan dengan DB)
        if (!empty($lpmd->gambar)) {
            $seoImage = asset('storage/' . $lpmd->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 4. Logic Deskripsi
        // Ambil dari profil LPMD, bersihkan HTML tags, potong 150 huruf
        $deskripsi = 'Profil Lembaga Pemberdayaan Masyarakat Desa (LPMD) ' . $namaDesa;
        if (!empty($lpmd->profil)) { // Asumsi nama kolomnya 'profil' atau 'deskripsi'
            $deskripsi = Str::limit(strip_tags($lpmd->profil), 150);
        }

        // 5. Set SEO Helper
        SeoHelper::set(
            title: 'LPMD - Website Resmi ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        return view('frontend.pages.lpmd.index', compact('lpmd'));
    }
}

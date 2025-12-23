<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (buat nama desa & logo cadangan)
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Aplikasi
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. Logic Smart Thumbnail
        // Coba ambil 1 foto galeri paling baru buat jadi cover link
        $latestFoto = Galeri::latest()->first();

        $seoImage = '';

        // Cek: Kalau ada data galeri, pakai foto terbarunya
        // (Pastikan nama kolom di DB kamu 'file', 'image', atau 'gambar'. Sesuaikan disini)
        if ($latestFoto && !empty($latestFoto->gambar)) {
            $seoImage = asset('storage/' . $latestFoto->gambar);
        }
        // Fallback: Kalau galeri kosong melompong, pakai Logo Desa
        elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 3. Set SEO Helper
        SeoHelper::set(
            title: 'Galeri Kegiatan - Website Resmi ' . $namaDesa,
            description: 'Dokumentasi visual kegiatan, pembangunan, potensi desa, dan momen-momen penting di ' . $namaDesa . '.',
            image: $seoImage
        );

        // 4. Logic Data Utama (Tetap sama)
        $galeri = Galeri::latest()->paginate(8);

        return view('frontend.pages.galeri.index', compact('galeri'));
    }
}

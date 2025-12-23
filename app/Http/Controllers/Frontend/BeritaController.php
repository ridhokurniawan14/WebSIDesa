<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi; // <--- Import Aplikasi buat Logo & Nama Desa
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Helpers\SeoHelper;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Data Aplikasi untuk SEO (Nama Desa & Logo)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. SET SEO untuk Halaman INDEX (Daftar Berita)
        // Default image pakai Logo Desa
        $seoImageIndex = ($aplikasi && $aplikasi->logo) ? asset('storage/' . $aplikasi->logo) : '';

        SeoHelper::set(
            title: 'Berita & Informasi - Website Resmi ' . $namaDesa,
            description: 'Indeks berita terkini, pengumuman, dan kegiatan terbaru di ' . $namaDesa,
            image: $seoImageIndex
        );

        // 3. Logic Query Berita (Search & Pagination)
        $query = Berita::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('excerpt', 'like', "%{$keyword}%");
            });
        }

        $beritas = $query->orderBy('date', 'desc')
            ->paginate(6)
            ->withQueryString();

        return view('frontend.pages.berita.index', compact('beritas'));
    }

    public function show($slug)
    {
        // 1. Ambil data
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $aplikasi = Aplikasi::first(); // Ambil data aplikasi
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. Increment views
        $berita->increment('views');

        // 3. Logic Gambar SEO (PENTING!)
        // Prioritas: Thumbnail Berita -> Fallback: Logo Desa
        $seoImage = '';

        if (!empty($berita->thumbnail)) {
            // Cek apakah link external (https://...) atau local storage
            if (Str::startsWith($berita->thumbnail, ['http', 'https'])) {
                $seoImage = $berita->thumbnail;
            } else {
                $seoImage = asset('storage/' . $berita->thumbnail);
            }
        }

        // Jika berita gak punya gambar, pakai LOGO DESA sebagai cadangan
        if (empty($seoImage) && $aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 4. Deskripsi SEO
        // Ambil dari konten, bersihkan tag HTML, ambil 150 karakter
        $deskripsiSingkat = Str::limit(strip_tags($berita->content), 150);

        // 5. Set SEO Helper
        SeoHelper::set(
            title: $berita->title . ' - ' . $namaDesa, // Judul Berita - Nama Desa
            description: $deskripsiSingkat,
            image: $seoImage
        );

        // 6. Ambil berita lain (Sidebar)
        $latest = Berita::where('slug', '!=', $slug)
            ->latest('date')
            ->take(5)
            ->get();

        return view('frontend.pages.berita.detail', compact('berita', 'latest'));
    }
}

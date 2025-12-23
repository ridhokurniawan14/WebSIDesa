<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi buat Logo & Nama
use App\Models\ProdukHukum;
use Illuminate\Http\Request;

class ProdukHukumController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. SETUP SEO ---
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Image: Gunakan Logo Desa karena ini dokumen resmi
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Produk Hukum & Transparansi - Website Resmi ' . $namaDesa,
            description: 'Daftar Peraturan Desa (Perdes), Peraturan Kepala Desa, dan Surat Keputusan (SK) yang berlaku di ' . $namaDesa . '.',
            image: $seoImage
        );

        // --- 2. LOGIC DATA (Tetap Sama) ---

        // Ambil Data Tabel
        $data = ProdukHukum::orderBy('tahun', 'desc')->latest()->get();

        // Ambil List Tahun yang TERSEDIA saja di DB
        $tahun_tersedia = ProdukHukum::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.pages.produk-hukum.index', compact('data', 'tahun_tersedia'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use App\Models\Aplikasi;
use App\Models\Beranda;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $aplikasi = Aplikasi::first();

        // --- LOGIC SEO ---

        // 1. Title
        $namaDesa = $aplikasi ? $aplikasi->nama_desa : 'Desa';
        $seoTitle = 'Beranda - Website Resmi ' . $namaDesa;

        // 2. Description
        $seoDesc = 'Website resmi ' . $namaDesa;
        if ($beranda && !empty($beranda->deskripsi)) {
            $cleanDesc = strip_tags($beranda->deskripsi);
            $seoDesc = Str::limit($cleanDesc, 150);
        }

        // 3. Image (Thumbnail WA)
        $seoImage = '';

        // Cek Logo Aplikasi
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // Cek Banner Beranda (Prioritas Timpa Logo jika ada)
        if ($beranda && !empty($beranda->banner_images) && is_array($beranda->banner_images)) {
            if (isset($beranda->banner_images[0])) {
                $seoImage = asset('storage/' . $beranda->banner_images[0]);
            }
        }

        // Set ke Helper (Hanya parameter yang dikenali)
        SeoHelper::set(
            title: $seoTitle,
            description: $seoDesc,
            image: $seoImage
        );

        // --- DATA LAINNYA ---
        $beritaTerbaru = Berita::latest('date')->take(6)->get();

        $tahun = date('Y');
        $dataApbdes = Apbdes::where('tahun', $tahun)->get();

        $totalPendapatan = $dataApbdes->where('jenis', 'pendapatan')->sum('anggaran');
        $totalBelanja    = $dataApbdes->where('jenis', 'belanja')->sum('anggaran');
        $totalPembiayaan = $dataApbdes->where('jenis', 'pembiayaan')->sum('anggaran');
        $surplusDefisit  = $totalPendapatan - $totalBelanja;
        $silpa           = $surplusDefisit + $totalPembiayaan;

        return view('frontend.pages.home.index', compact(
            'beranda',
            'beritaTerbaru',
            'totalPendapatan',
            'totalBelanja',
            'totalPembiayaan',
            'surplusDefisit',
            'silpa'
        ));
    }
}

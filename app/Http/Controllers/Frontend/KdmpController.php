<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama Desa & Logo)
use App\Models\Kdmp;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <--- Import Str

class KdmpController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Koperasi
        $koperasi = Kdmp::first();

        // Validasi jika data kosong
        if (!$koperasi) {
            abort(404, 'Data Koperasi Desa Merah Putih belum diisi.');
        }

        // 2. Ambil Data Aplikasi (Nama Desa & Logo)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 3. Logic Image SEO (Smart Thumbnail)
        // Prioritas: Foto Koperasi -> Fallback: Logo Desa
        $seoImage = '';

        // Cek nama kolom gambar di DB (misal: 'gambar', 'foto', atau 'struktur')
        if (!empty($koperasi->gambar)) {
            $seoImage = asset('storage/' . $koperasi->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 4. Logic Deskripsi
        // Ambil dari profil koperasi, bersihkan HTML, potong 150 huruf
        $deskripsi = 'Profil Koperasi Desa Merah Putih (KDMP) ' . $namaDesa . '. Usaha ekonomi produktif milik desa.';

        // Asumsi nama kolom deskripsi adalah 'deskripsi' atau 'profil'
        if (!empty($koperasi->deskripsi)) {
            $deskripsi = Str::limit(strip_tags($koperasi->deskripsi), 150);
        }

        // 5. Set SEO Helper
        SeoHelper::set(
            title: 'Koperasi Desa Merah Putih (KDMP) - ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        // 6. Return View
        return view('frontend.pages.koperasidesamerahputih.index', compact('koperasi'));
    }
}

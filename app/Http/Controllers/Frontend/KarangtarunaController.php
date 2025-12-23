<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama Desa & Logo)
use App\Models\KarangTaruna;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <--- Import Str

class KarangtarunaController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Karang Taruna
        $karangtaruna = KarangTaruna::first();

        // Cek jika data kosong
        if (!$karangtaruna) {
            abort(404, 'Data Karang Taruna belum diisi oleh Admin.');
        }

        // 2. Ambil Data Aplikasi (Nama Desa & Logo)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 3. Logic Image SEO (Smart Thumbnail)
        // Prioritas: Foto Kegiatan/Struktur Karang Taruna -> Fallback: Logo Desa
        $seoImage = '';

        // Cek kolom gambar di DB (sesuaikan jika namanya 'foto' atau 'struktur')
        if (!empty($karangtaruna->gambar)) {
            $seoImage = asset('storage/' . $karangtaruna->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 4. Logic Deskripsi
        // Ambil dari profil/deskripsi, bersihkan HTML, potong 150 huruf
        $deskripsi = 'Profil Organisasi Kepemudaan Karang Taruna ' . $namaDesa;

        if (!empty($karangtaruna->deskripsi)) { // Sesuaikan nama kolom: deskripsi/profil
            $deskripsi = Str::limit(strip_tags($karangtaruna->deskripsi), 150);
        }

        // 5. Set SEO Helper
        SeoHelper::set(
            title: 'Karang Taruna - Website Resmi ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        return view('frontend.pages.karangtaruna.index', compact('karangtaruna'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama & Logo)
use App\Models\Pkk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PkkController extends Controller
{
    public function index()
    {
        // 1. Ambil Data
        $pkk = Pkk::first(); // Ambil object utuh
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. Logic Image SEO
        // Prioritas: Foto PKK (Struktur/Kegiatan) -> Fallback: Logo Desa
        $seoImage = '';

        // Cek apakah tabel pkks punya kolom 'gambar'. Sesuaikan jika namanya 'foto' atau 'image'.
        if ($pkk && !empty($pkk->gambar)) {
            $seoImage = asset('storage/' . $pkk->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 3. Logic Deskripsi
        // Ambil dari profil PKK, jika kosong pakai default text
        $deskripsi = 'Profil, Struktur Pengurus, dan 10 Program Pokok PKK Desa ' . $namaDesa;

        // Asumsi kolom deskripsi di tabel pkks namanya 'profil' atau 'deskripsi'
        if ($pkk && !empty($pkk->profil)) {
            $deskripsi = Str::limit(strip_tags($pkk->profil), 150);
        }

        // 4. Set SEO Helper
        SeoHelper::set(
            title: 'PKK (Pemberdayaan Kesejahteraan Keluarga) - ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        // 5. Logic Parsing Data (Code Bawaan)
        // Pecah JSON untuk looping, tapi tetap kirim $pkk untuk data single field
        $pengurus = $pkk ? $pkk->pengurus : [];
        $kegiatan = $pkk ? $pkk->kegiatan : [];
        $program_pokok = $pkk ? $pkk->program_pokok : [];

        // Tambahkan 'pkk' ke dalam compact
        return view('frontend.pages.pkk.index', compact('pkk', 'pengurus', 'kegiatan', 'program_pokok'));
    }
}

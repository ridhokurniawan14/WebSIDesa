<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Models\Aplikasi; // <--- JANGAN LUPA IMPORT INI
use App\Models\Perangkat;
use App\Models\Peta;
use App\Models\Sejarah;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    // Helper function biar gak ngulang-ngulang kode ambil data Aplikasi
    private function getAplikasiData()
    {
        return Aplikasi::first();
    }

    public function visiMisi()
    {
        $data = VisiMisi::first();
        $aplikasi = $this->getAplikasiData();

        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Image: Gunakan logo desa sebagai default karena Visi Misi biasanya teks saja
        $seoImage = ($aplikasi && $aplikasi->logo) ? asset('storage/' . $aplikasi->logo) : '';

        SeoHelper::set(
            title: 'Visi Misi - Website Resmi ' . $namaDesa,
            description: 'Visi dan Misi Pemerintah ' . $namaDesa . '. Mewujudkan desa yang maju, mandiri, dan sejahtera.',
            image: $seoImage
        );

        return view('frontend.pages.profil.visi-misi', compact('data'));
    }

    public function sejarah()
    {
        $sejarah = Sejarah::first();
        $aplikasi = $this->getAplikasiData();

        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Deskripsi: Ambil cuplikan sejarah jika ada
        $deskripsi = 'Sejarah dan asal usul ' . $namaDesa;
        if ($sejarah && !empty($sejarah->deskripsi)) {
            $deskripsi = Str::limit(strip_tags($sejarah->deskripsi), 150);
        }

        // Image: Prioritas FOTO SEJARAH -> Fallback LOGO DESA
        $seoImage = '';
        if ($sejarah && !empty($sejarah->foto)) {
            $seoImage = asset('storage/' . $sejarah->foto);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Sejarah - Website Resmi ' . $namaDesa,
            description: $deskripsi,
            image: $seoImage
        );

        return view('frontend.pages.profil.sejarah', compact('sejarah'));
    }

    public function perangkat()
    {
        // Asumsi: Ini menampilkan Kepala Desa atau Struktur Organisasi
        $perangkat = Perangkat::first();
        $aplikasi = $this->getAplikasiData();

        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Image: Prioritas FOTO PERANGKAT -> Fallback LOGO DESA
        $seoImage = '';
        // Pastikan field foto di db benar (misal: 'foto', 'image', atau 'gambar')
        if ($perangkat && !empty($perangkat->foto)) {
            $seoImage = asset('storage/' . $perangkat->foto);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Perangkat Desa - Website Resmi ' . $namaDesa,
            description: 'Struktur organisasi dan profil perangkat ' . $namaDesa,
            image: $seoImage
        );

        return view('frontend.pages.profil.perangkat-desa', compact('perangkat'));
    }

    public function peta()
    {
        $peta = Peta::first();
        $aplikasi = $this->getAplikasiData();

        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Image: Prioritas GAMBAR PETA -> Fallback LOGO DESA
        $seoImage = '';
        // Cek apakah model Peta punya kolom 'gambar' atau 'foto' (sesuaikan dgn DB kamu)
        if ($peta && !empty($peta->gambar)) {
            $seoImage = asset('storage/' . $peta->gambar);
        } elseif ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Peta Wilayah - Website Resmi ' . $namaDesa,
            description: 'Peta wilayah dan lokasi administratif ' . $namaDesa,
            image: $seoImage
        );

        return view('frontend.pages.profil.peta-desa', compact('peta'));
    }
}

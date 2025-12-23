<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Administrasi;
use App\Models\Aplikasi; // <--- Import Aplikasi buat ambil Logo & Nama Desa
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Aplikasi (Nama Desa & Logo)
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. Logic Image SEO (Default pakai Logo Desa)
        // Karena ini halaman list layanan, paling cocok pakai Logo Desa sebagai thumbnail WA
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 3. Set SEO Helper
        SeoHelper::set(
            title: 'Layanan Administrasi - Website Resmi ' . $namaDesa,
            description: 'Informasi lengkap panduan pengurusan surat, administrasi kependudukan, dan layanan publik lainnya di ' . $namaDesa . '.',
            image: $seoImage
        );

        // 4. Logic Data Halaman (Tetap sama)
        $kategori = [
            'kependudukan' => 'Administrasi Kependudukan',
            'surat-keterangan' => 'Surat Keterangan',
            'lainnya' => 'Lainnya'
        ];

        $layanan = Administrasi::latest()->get();

        return view('frontend.pages.administrasi-desa.index', [
            'layanan' => $layanan,
            'kategori' => $kategori,
        ]);
    }
}

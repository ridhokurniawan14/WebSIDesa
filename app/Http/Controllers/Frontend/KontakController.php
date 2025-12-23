<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper SEO
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Untuk Logo & Nama Desa)
use Illuminate\Http\Request;
use App\Models\Pesan;

class KontakController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Aplikasi
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // 2. Logic Image SEO
        // Untuk halaman kontak, WAJIB pakai Logo Desa agar terlihat resmi/official
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        // 3. Set SEO Helper
        SeoHelper::set(
            title: 'Kontak & Pengaduan - Website Resmi ' . $namaDesa,
            description: 'Saluran resmi komunikasi, layanan pengaduan, kritik, dan saran untuk Pemerintah ' . $namaDesa . '.',
            image: $seoImage
        );

        return view('frontend.pages.kontak.index');
    }

    public function kirim(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'nama'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'telepon' => 'required|string|max:20',
            'subject' => 'required|string|max:200',
            'pesan'   => 'required|string',
        ]);

        // 2. Simpan ke Database
        Pesan::create([
            'nama_lengkap' => $validated['nama'],
            'email'        => $validated['email'],
            'nomor_hp'     => $validated['telepon'],
            'subject'      => $validated['subject'],
            'isi_pesan'    => $validated['pesan'],
        ]);

        // 3. Redirect kembali
        return back()->with('success', 'Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.');
    }
}

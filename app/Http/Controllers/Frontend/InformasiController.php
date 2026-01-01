<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Nama Desa & Logo)
use App\Models\Pembangunan;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function apbdes()
    {
        // Cek tahun terbaru yang ada di database
        $tahunTerbaru = Apbdes::max('tahun');

        // Jika DB kosong, default ke tahun sekarang
        $tahun = $tahunTerbaru ?? date('Y');

        return redirect()->route('informasi.apbdes.tahun', $tahun);
    }

    public function apbdesTahun($tahun)
    {
        // --- 1. SETUP SEO APBDES ---
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Image: Gunakan Logo Desa
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Transparansi APBDes Tahun ' . $tahun . ' - ' . $namaDesa,
            description: 'Laporan Realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) ' . $namaDesa . ' Tahun Anggaran ' . $tahun . '.',
            image: $seoImage
        );

        // --- 2. LOGIC DATA ---

        // Ambil daftar tahun untuk filter
        $daftarTahun = Apbdes::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($daftarTahun->isEmpty()) {
            $daftarTahun = [date('Y')];
        }

        // Ambil semua data di tahun tersebut
        $dataApbdes = Apbdes::where('tahun', $tahun)->get();

        // Filter per Jenis
        // Pastikan penulisan 'pendapatan', 'belanja', 'pembiayaan' sesuai dengan yang ada di Database (Case Sensitive)
        $dataPendapatan = $dataApbdes->where('jenis', 'pendapatan');
        $dataBelanja    = $dataApbdes->where('jenis', 'belanja');

        // --- KHUSUS LOGIC PEMBIAYAAN (NETTO) ---
        // 1. Ambil data pembiayaan dan urutkan berdasarkan ID (Input 1 vs Input 2)
        $listPembiayaan = $dataApbdes->where('jenis', 'pembiayaan')->sortBy('id')->values();

        // 2. Tentukan Penerimaan (Input 1) dan Pengeluaran (Input 2)
        $p1_anggaran  = $listPembiayaan[0]->anggaran ?? 0;
        $p1_realisasi = $listPembiayaan[0]->realisasi ?? 0;

        $p2_anggaran  = $listPembiayaan[1]->anggaran ?? 0;
        $p2_realisasi = $listPembiayaan[1]->realisasi ?? 0;

        // 3. Hitung Total Pembiayaan Netto (Penerimaan - Pengeluaran)
        $totalPembiayaan = [
            'anggaran'  => $p1_anggaran - $p2_anggaran,
            'realisasi' => $p1_realisasi - $p2_realisasi
        ];
        // --- END LOGIC PEMBIAYAAN ---

        // Hitung Total Pendapatan & Belanja (Logic Sum Biasa)
        $totalPendapatan = [
            'anggaran'  => $dataPendapatan->sum('anggaran'),
            'realisasi' => $dataPendapatan->sum('realisasi')
        ];

        $totalBelanja = [
            'anggaran'  => $dataBelanja->sum('anggaran'),
            'realisasi' => $dataBelanja->sum('realisasi')
        ];

        // Hitung Surplus/Defisit (Pendapatan - Belanja)
        $surplusRealisasi = $totalPendapatan['realisasi'] - $totalBelanja['realisasi'];

        // Hitung SILPA (Surplus + Pembiayaan Netto)
        $silpaRealisasi = $surplusRealisasi + $totalPembiayaan['realisasi'];

        // Data Ringkasan untuk Chart/Card Atas
        $ringkasan = [
            'pendapatan' => $totalPendapatan['realisasi'],
            'belanja'    => $totalBelanja['realisasi'],
            'pembiayaan' => $totalPembiayaan['realisasi'], // Hasil Netto
            'surplus'    => $surplusRealisasi,
            'silpa'      => $silpaRealisasi,
        ];

        // Data Pelaksanaan untuk Tabel/Grafik Batang
        $pelaksanaan = [
            [
                'nama'      => 'Pendapatan',
                'anggaran'  => (int)$totalPendapatan['anggaran'],
                'realisasi' => (int)$totalPendapatan['realisasi']
            ],
            [
                'nama'      => 'Belanja',
                'anggaran'  => (int)$totalBelanja['anggaran'],
                'realisasi' => (int)$totalBelanja['realisasi']
            ],
            [
                'nama'      => 'Pembiayaan',
                'anggaran'  => (int)$totalPembiayaan['anggaran'],
                'realisasi' => (int)$totalPembiayaan['realisasi']
            ],
        ];

        return view('frontend.pages.transparansi.apbdes', [
            'tahun'        => $tahun,
            'daftarTahun'  => $daftarTahun,
            'ringkasan'    => $ringkasan,
            'pelaksanaan'  => $pelaksanaan,
            'pendapatan'   => $dataPendapatan,
            'pembelanjaan' => $dataBelanja,
            // Saya tambahkan 'pembiayaan' disini siapa tau view butuh detail item-nya
            'pembiayaan'   => $listPembiayaan,
        ]);
    }

    public function pembangunan(Request $request)
    {
        // --- 1. SETUP SEO PEMBANGUNAN ---
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // --- 2. LOGIC FILTER DATA ---
        $query = Pembangunan::query();

        if ($request->filled('desa')) {
            $query->where('desa', $request->desa);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $items = $query->latest('tahun')
            ->latest('created_at')
            ->paginate(6);

        $items->appends($request->all());

        // --- 3. LANJUTAN SEO IMAGE (SMART THUMBNAIL) ---
        // FIX: Handle kolom foto yang isinya Array/JSON

        $seoImage = '';
        $firstItem = $items->first(); // Ambil item pertama

        if ($firstItem && !empty($firstItem->foto)) {
            // Cek apakah data foto sudah berbentuk Array (karena casting di Model)
            // atau masih berbentuk String JSON
            $photos = $firstItem->foto;

            if (is_string($photos)) {
                // Kalau masih string JSON '["img1.jpg", "img2.jpg"]', kita decode dulu
                $photos = json_decode($photos, true);
            }

            // Jika sudah jadi array dan ada isinya, ambil index ke-0 (Gambar Pertama)
            if (is_array($photos) && count($photos) > 0) {
                $seoImage = asset('storage/' . $photos[0]);
            }
        }

        // Fallback: Jika logic di atas gagal atau tidak ada foto, pakai Logo Desa
        if (empty($seoImage) && $aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Pembangunan Desa - Website Resmi ' . $namaDesa,
            description: 'Informasi transparansi kegiatan pembangunan infrastruktur dan pemberdayaan di ' . $namaDesa . '.',
            image: $seoImage
        );

        // --- 4. RETURN VIEW ---
        $desas = Pembangunan::select('desa')->distinct()->orderBy('desa')->pluck('desa');
        $years = Pembangunan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('frontend.pages.transparansi.pembangunan', compact('items', 'desas', 'years'));
    }
}

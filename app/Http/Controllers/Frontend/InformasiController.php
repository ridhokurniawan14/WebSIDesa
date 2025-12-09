<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function apbdes()
    {
        $tahun = date('Y');
        return redirect()->route('informasi.apbdes.tahun', $tahun);
    }

    public function apbdesTahun($tahun)
    {
        // Tahun untuk dropdown
        $daftarTahun = range(2020, date('Y'));

        // Ringkasan (acak untuk demo)
        $ringkasan = [
            'pendapatan' => 1250000000,
            'belanja' => 1180000000,
            'pembiayaan' => 150000000,
            'surplus' => 70000000,
            'silpa' => 52000000,
        ];

        // Grafik pelaksanaan
        $pelaksanaan = [
            ['nama' => 'Pendapatan', 'anggaran' => 1300000000, 'realisasi' => 1250000000],
            ['nama' => 'Belanja', 'anggaran' => 1250000000, 'realisasi' => 1180000000],
            ['nama' => 'Pembiayaan', 'anggaran' => 160000000, 'realisasi' => 150000000],
        ];

        // Detail pendapatan
        $pendapatan = [
            ['nama' => 'Hasil Aset Desa', 'anggaran' => 20000000, 'realisasi' => 18000000],
            ['nama' => 'Dana Desa', 'anggaran' => 900000000, 'realisasi' => 870000000],
            ['nama' => 'Bagi Hasil Pajak & Retribusi', 'anggaran' => 55000000, 'realisasi' => 54000000],
            ['nama' => 'Alokasi Dana Desa', 'anggaran' => 250000000, 'realisasi' => 240000000],
            ['nama' => 'Bunga Bank', 'anggaran' => 5000000, 'realisasi' => 4900000],
            ['nama' => 'Pendapatan Sah Lainnya', 'anggaran' => 10000000, 'realisasi' => 9500000],
        ];

        // Detail belanja
        $pembelanjaan = [
            ['nama' => 'Penyelenggaraan Pemerintahan', 'anggaran' => 400000000, 'realisasi' => 380000000],
            ['nama' => 'Pembangunan Desa', 'anggaran' => 500000000, 'realisasi' => 470000000],
            ['nama' => 'Pembinaan Kemasyarakatan', 'anggaran' => 120000000, 'realisasi' => 110000000],
            ['nama' => 'Pemberdayaan Masyarakat', 'anggaran' => 140000000, 'realisasi' => 130000000],
            ['nama' => 'Penanggulangan Bencana', 'anggaran' => 90000000, 'realisasi' => 85000000],
        ];

        return view('frontend.pages.transparansi.apbdes', compact(
            'tahun',
            'daftarTahun',
            'ringkasan',
            'pelaksanaan',
            'pendapatan',
            'pembelanjaan'
        ));
    }

    public function pembangunan()
    {
        return view('frontend.pages.transparansi.pembangunan');
    }
}

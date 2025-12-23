<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper; // <--- Import Helper
use App\Http\Controllers\Controller;
use App\Models\Aplikasi;   // <--- Import Aplikasi (Buat Logo & Nama Desa)
use App\Models\Rw;
use Illuminate\Http\Request;

class RtrwController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. SETUP SEO ---
        $aplikasi = Aplikasi::first();
        $namaDesa = $aplikasi->nama_desa ?? 'Desa';

        // Logic Image: Gunakan Logo Desa sebagai thumbnail WA
        // Karena ini data administratif, logo adalah representasi terbaik.
        $seoImage = '';
        if ($aplikasi && !empty($aplikasi->logo)) {
            $seoImage = asset('storage/' . $aplikasi->logo);
        }

        SeoHelper::set(
            title: 'Kelembagaan RT & RW - Website Resmi ' . $namaDesa,
            description: 'Daftar lengkap pengurus Rukun Tetangga (RT) dan Rukun Warga (RW) di seluruh wilayah Dusun ' . $namaDesa . '.',
            image: $seoImage
        );

        // --- 2. LOGIC DATA (Tetap Sama) ---

        // Siapkan Query Dasar + Relasi RT
        $query = Rw::with('rts');

        // Logic Pencarian (Search Global)
        if ($q = $request->q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('dusun', 'like', "%$q%")
                    ->orWhere('nomor_rw', 'like', "%$q%")
                    ->orWhere('nama_ketua_rw', 'like', "%$q%")
                    ->orWhereHas('rts', function ($rtQuery) use ($q) {
                        $rtQuery->where('nomor_rt', 'like', "%$q%")
                            ->orWhere('nama_ketua_rt', 'like', "%$q%");
                    });
            });
        }

        // Filter Spesifik Dusun (Dropdown)
        if ($dusun = $request->dusun) {
            $query->where('dusun', $dusun);
        }

        // Urutkan Data
        $data = $query->orderBy('dusun')
            ->orderBy('nomor_rw')
            ->paginate(9)
            ->withQueryString();

        // Data Opsi Dusun (Hardcode atau dari DB)
        $dusunOptions = ['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'];

        return view('frontend.pages.rtrw.index', compact('data', 'dusunOptions'));
    }
}

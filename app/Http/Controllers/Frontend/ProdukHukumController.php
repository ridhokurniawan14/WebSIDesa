<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukHukumController extends Controller
{
    public function index(Request $request)
    {
        // Data statis dulu
        $data = [
            [
                'id' => 1,
                'judul' => 'Peraturan Desa Tentang Pengelolaan Aset Desa',
                'jenis' => 'Peraturan Desa',
                'tahun' => 2022,
                'file' => '/pdf/contoh1.pdf',
            ],
            [
                'id' => 2,
                'judul' => 'Keputusan Kepala Desa Tentang Penetapan APBDes',
                'jenis' => 'Keputusan Kepala Desa',
                'tahun' => 2023,
                'file' => '/pdf/contoh2.pdf',
            ],
            [
                'id' => 3,
                'judul' => 'Surat Edaran Kepala Desa Tentang Peringatan Kebersihan',
                'jenis' => 'Surat Edaran Kepala Desa',
                'tahun' => 2024,
                'file' => '/pdf/contoh3.pdf',
            ],
        ];

        return view('frontend.pages.produk-hukum.index', compact('data'));
    }
}

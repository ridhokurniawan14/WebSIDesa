<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosyanduController extends Controller
{
    public function index()
    {
        $posyandu = [
            'deskripsi' => '
                Posyandu (Pos Pelayanan Terpadu) adalah wadah pelayanan kesehatan
                yang dikelola dari, oleh, dan untuk masyarakat dalam penyelenggaraan
                pembangunan kesehatan agar masyarakat memperoleh pelayanan dasar
                yang dekat, cepat, dan mudah dijangkau.
            ',

            'tujuan' => [
                'Meningkatkan derajat kesehatan masyarakat terutama ibu dan anak.',
                'Meningkatkan cakupan pelayanan kesehatan dasar.',
                'Mendorong peran serta masyarakat dalam penyelenggaraan kesehatan.',
                'Mempermudah akses masyarakat terhadap pelayanan kesehatan.',
            ],

            'layanan' => [
                'Penimbangan balita',
                'Pelayanan imunisasi',
                'Pemeriksaan ibu hamil',
                'Pemberian vitamin & PMT (Pemberian Makanan Tambahan)',
                'Konseling gizi dan kesehatan',
                'Pencatatan dan pelaporan kesehatan ibu & anak',
            ],

            'sasaran' => [
                'Balita',
                'Ibu hamil',
                'Ibu menyusui',
                'Pasangan usia subur',
                'Lansia (jika termasuk Posyandu Lansia)',
            ],

            'jadwal' => 'Setiap tanggal 10 setiap bulan (bisa disesuaikan desa).',

            'struktur' => [
                'gambar' => '/frontend/images/posyandu/struktur-posyandu.png',
                'ketua' => 'Nama Ketua Posyandu',
                'sekretaris' => 'Nama Sekretaris',
                'bendahara' => 'Nama Bendahara',
                'kader' => [
                    'Nama Kader 1',
                    'Nama Kader 2',
                    'Nama Kader 3',
                    'Nama Kader 4',
                ]
            ],

            'program' => [
                'Pelaksanaan Posyandu rutin setiap bulan.',
                'Pemberian PMT balita.',
                'Pemeriksaan ibu hamil dan konseling.',
                'Pelatihan kader posyandu.',
                'Pendataan tumbuh kembang balita.',
            ],
            'kontak' => [
                [
                    'nama' => 'Nama Ketua Posyandu',
                    'jabatan' => 'Ketua',
                    'telepon' => '0812-3456-7890',
                ],
                [
                    'nama' => 'Nama Sekretaris',
                    'jabatan' => 'Sekretaris',
                    'telepon' => '0813-9876-5432',
                ],
                [
                    'nama' => 'Nama Kader 1',
                    'jabatan' => 'Kader',
                    'telepon' => '0852-1111-2222',
                ],
            ]
        ];

        return view('frontend.pages.posyandu.index', compact('posyandu'));
    }
}

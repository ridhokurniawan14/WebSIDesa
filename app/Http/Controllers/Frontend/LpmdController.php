<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LpmdController extends Controller
{
    public function index()
    {
        // Data statis
        $lpmd = [
            'deskripsi' => '
                LPMD (Lembaga Pemberdayaan Masyarakat Desa) adalah lembaga
                yang dibentuk oleh masyarakat desa sebagai mitra pemerintah desa
                untuk membantu dalam proses perencanaan, pelaksanaan, dan
                pengendalian pembangunan desa.
            ',

            'dasar_hukum' => [
                'Undang-Undang Nomor 6 Tahun 2014 tentang Desa',
                'Permendagri Nomor 18 Tahun 2018 tentang LPMD dan LPMK',
                'Peraturan Desa terkait LPMD (jika ada)',
            ],

            'tugas_fungsi' => [
                'Membantu pemerintah desa dalam perencanaan pembangunan',
                'Menampung dan menyalurkan aspirasi masyarakat',
                'Mendorong partisipasi masyarakat dalam pembangunan',
                'Melaksanakan kegiatan pemberdayaan masyarakat',
                'Melaksanakan kegiatan pemberdayaan masyarakat',
                'Melaksanakan kegiatan pemberdayaan masyarakat',
                'Melakukan pengawasan terhadap pelaksanaan pembangunan desa',
            ],

            'struktur' => [
                'gambar' => '/frontend/images/lpmd/struktur-lpmd.png',
                'ketua' => 'Nama Ketua',
                'sekretaris' => 'Nama Sekretaris',
                'bendahara' => 'Nama Bendahara',
                'bidang' => [
                    'Bidang Keagamaan' => 'Nama Penanggung Jawab',
                    'Bidang Pembangunan dan Lingkungan Hidup' => 'Nama Penanggung Jawab',
                    'Bidang Ekonomi, Sosial, dan Budaya' => 'Nama Penanggung Jawab',
                    'Bidang Pendidikan, Pemuda dan Olahraga' => 'Nama Penanggung Jawab',
                ]
            ],

            'program' => [
                'Penyusunan perencanaan pembangunan desa',
                'Fasilitasi kegiatan masyarakat',
                'Pelatihan dan pemberdayaan ekonomi masyarakat',
                'Pendampingan kegiatan pembangunan',
                'Monitoring pelaksanaan pembangunan desa',
            ]
        ];

        return view('frontend.pages.lpmd.index', compact('lpmd'));
    }
}

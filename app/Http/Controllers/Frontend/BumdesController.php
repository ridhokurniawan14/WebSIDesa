<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BumdesController extends Controller
{
    public function index()
    {
        $data = [
            'nama' => 'BUMDes Maju Sejahtera',
            'slogan' => 'Menggerakkan Ekonomi Desa',

            'tentang' => 'Badan Usaha Milik Desa (BUMDes) merupakan lembaga usaha desa yang dikelola secara profesional untuk meningkatkan perekonomian dan kesejahteraan masyarakat desa.',

            'visi' => 'Menjadi penggerak ekonomi desa yang mandiri dan berkelanjutan.',

            'misi' => [
                'Mengembangkan potensi ekonomi lokal desa',
                'Menciptakan lapangan kerja bagi masyarakat',
                'Meningkatkan pendapatan asli desa',
                'Mendukung UMKM desa'
            ],

            'unit_usaha' => [
                [
                    'nama' => 'Simpan Pinjam',
                    'deskripsi' => 'Melayani kebutuhan permodalan masyarakat desa.'
                ],
                [
                    'nama' => 'Perdagangan',
                    'deskripsi' => 'Pengelolaan usaha jual beli kebutuhan pokok.'
                ],
                [
                    'nama' => 'Jasa',
                    'deskripsi' => 'Layanan jasa sesuai kebutuhan masyarakat desa.'
                ],
                [
                    'nama' => 'Pengelolaan UMKM',
                    'deskripsi' => 'Pendampingan dan pemasaran produk UMKM desa.'
                ],
            ],

            'pengurus' => [
                'direktur' => 'Budi Santoso',
                'sekretaris' => 'Siti Aminah',
                'bendahara' => 'Ahmad Fauzi',
            ],

            'kontak' => [
                'alamat' => 'Kantor Desa Contoh, Kecamatan Contoh',
                'telepon' => '0812-3456-7890',
                'email' => 'bumdes@desa.id'
            ]
        ];

        return view('frontend.pages.bumdes.index', $data);
    }
}

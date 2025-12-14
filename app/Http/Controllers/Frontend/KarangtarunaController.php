<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KarangtarunaController extends Controller
{
    public function index()
    {
        $karangtaruna = [
            'nama' => 'Karang Taruna Desa Maju Jaya',
            'deskripsi' => 'Organisasi kepemudaan desa yang berperan aktif dalam kegiatan sosial, pengembangan potensi pemuda, dan pembangunan desa.',

            'visi' => 'Mewujudkan pemuda desa yang mandiri, kreatif, dan peduli terhadap lingkungan sosial.',

            'misi' => [
                'Meningkatkan peran aktif pemuda dalam pembangunan desa',
                'Mengembangkan kreativitas dan jiwa kewirausahaan pemuda',
                'Menumbuhkan kepedulian sosial dan solidaritas masyarakat',
            ],

            'program' => [
                [
                    'judul' => 'Pemuda Peduli Lingkungan',
                    'deskripsi' => 'Kegiatan kebersihan desa, penanaman pohon, dan pengelolaan lingkungan.',
                    'icon' => '🌱'
                ],
                [
                    'judul' => 'Pelatihan Kewirausahaan',
                    'deskripsi' => 'Pelatihan usaha kecil, UMKM, dan ekonomi kreatif bagi pemuda.',
                    'icon' => '💼'
                ],
                [
                    'judul' => 'Olahraga & Seni',
                    'deskripsi' => 'Turnamen olahraga, seni budaya, dan kreativitas pemuda.',
                    'icon' => '⚽'
                ],
            ],

            'galeri' => [
                ['judul' => 'Kerja Bakti Desa', 'gambar' => 'karangtaruna1.jpg'],
                ['judul' => 'Pelatihan Pemuda', 'gambar' => 'karangtaruna2.jpg'],
                ['judul' => 'Turnamen Olahraga', 'gambar' => 'karangtaruna3.jpg'],
                ['judul' => 'Kegiatan Sosial', 'gambar' => 'karangtaruna4.jpg'],
            ],

            'pengurus' => [
                ['jabatan' => 'Ketua', 'nama' => 'Ahmad Fauzi'],
                ['jabatan' => 'Sekretaris', 'nama' => 'Siti Rahma'],
                ['jabatan' => 'Bendahara', 'nama' => 'Rizki Pratama'],
            ],

            'kontak' => [
                'telepon' => '0812-3456-7890',
                'email' => 'karangtaruna@desa.id',
                'instagram' => 'karangtaruna.desa'
            ],
        ];

        return view('frontend.pages.karangtaruna.index', compact('karangtaruna'));
    }
}

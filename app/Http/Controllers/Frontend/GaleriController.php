<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    private $items;

    public function __construct()
    {
        // Data statis diperbanyak jadi 8 item
        $this->items = [
            [
                'title' => 'Kegiatan Gotong Royong Bersih Desa',
                'slug'  => 'kegiatan-gotong-royong',
                'image' => 'https://kip.kapuaskab.go.id/files/berita/07112021024719_0.jpeg',
                'date'  => '2024-05-12'
            ],
            [
                'title' => 'Pembangunan Jembatan Penghubung',
                'slug'  => 'pembangunan-jembatan-desa',
                'image' => 'https://mmc.kalteng.go.id/files/berita/18012020074218_0.jpg',
                'date'  => '2024-07-01'
            ],
            [
                'title' => 'Pelatihan Digital Marketing UMKM',
                'slug'  => 'pelatihan-umkm-desa',
                'image' => 'https://cdn.8mediatech.com/gambar/78932834743-pelatihan_umkm_wajib_efektif.jpeg',
                'date'  => '2024-08-15'
            ],
            // Data Tambahan 1
            [
                'title' => 'Panen Raya Padi Organik',
                'slug'  => 'panen-raya-padi',
                'image' => 'https://images.unsplash.com/photo-1625246333195-551e50519938?q=80&w=1000&auto=format&fit=crop',
                'date'  => '2024-09-01'
            ],
            // Data Tambahan 2
            [
                'title' => 'Musyawarah Perencanaan Desa',
                'slug'  => 'musrenbang-desa',
                'image' => 'https://images.unsplash.com/photo-1577962917302-cd874c4e3169?q=80&w=1000&auto=format&fit=crop',
                'date'  => '2024-09-10'
            ],
            // Data Tambahan 3
            [
                'title' => 'Penyaluran Bantuan Langsung Tunai',
                'slug'  => 'penyaluran-blt',
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=1000&auto=format&fit=crop',
                'date'  => '2024-09-20'
            ],
            // Data Tambahan 4
            [
                'title' => 'Posyandu Balita & Lansia',
                'slug'  => 'kegiatan-posyandu',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1000&auto=format&fit=crop',
                'date'  => '2024-10-05'
            ],
            // Data Tambahan 5
            [
                'title' => 'Festival Budaya Desa Tahunan',
                'slug'  => 'festival-budaya',
                'image' => 'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1000&auto=format&fit=crop',
                'date'  => '2024-10-12'
            ],
        ];
    }

    public function index()
    {
        $galeri = $this->items;
        return view('frontend.pages.galeri.index', compact('galeri'));
    }
}

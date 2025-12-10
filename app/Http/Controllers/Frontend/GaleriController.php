<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    private $items;

    public function __construct()
    {
        // Data statis
        $this->items = [
            [
                'title' => 'Kegiatan Gotong Royong',
                'slug'  => 'kegiatan-gotong-royong',
                'image' => 'img/galeri/gotongroyong.jpg',
                'date'  => '2024-05-12'
            ],
            [
                'title' => 'Pembangunan Jembatan Desa',
                'slug'  => 'pembangunan-jembatan-desa',
                'image' => 'img/galeri/jembatan.jpg',
                'date'  => '2024-07-01'
            ],
            [
                'title' => 'Pelatihan UMKM Desa',
                'slug'  => 'pelatihan-umkm-desa',
                'image' => 'img/galeri/umkm.jpg',
                'date'  => '2024-08-15'
            ],
        ];
    }

    public function index()
    {
        $galeri = $this->items;

        return view('frontend.galeri.index', compact('galeri'));
    }

    public function show($slug)
    {
        $item = collect($this->items)->firstWhere('slug', $slug);

        abort_if(!$item, 404);

        return view('frontend.galeri.show', compact('item'));
    }
}

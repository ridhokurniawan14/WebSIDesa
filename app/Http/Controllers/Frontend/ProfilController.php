<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function visiMisi()
    {
        SeoHelper::set(
            title: 'Visi Misi - Website Resmi Desa',
            description: 'Website resmi Desa, menyediakan informasi publik, layanan, berita, dan profil desa.',
            image: $image ?? 'https://ridhokurniawan.my.id/img/rk.png'
        );

        return view('frontend.pages.profil.visi-misi');
    }
    public function sejarah()
    {
        SeoHelper::set(
            title: 'Sejarah - Website Resmi Desa',
            description: 'Website resmi Desa, menyediakan informasi publik, layanan, berita, dan profil desa.',
            image: $image ?? 'https://ridhokurniawan.my.id/img/rk.png'
        );

        return view('frontend.pages.profil.sejarah');
    }
    public function perangkat()
    {
        SeoHelper::set(
            title: 'Perangkat Desa - Website Resmi Desa',
            description: 'Website resmi Desa, menyediakan informasi publik, layanan, berita, dan profil desa.',
            image: $image ?? 'https://ridhokurniawan.my.id/img/rk.png'
        );

        return view('frontend.pages.profil.perangkat-desa');
    }
    public function peta()
    {
        SeoHelper::set(
            title: 'Peta Desa - Website Resmi Desa',
            description: 'Website resmi Desa, menyediakan informasi publik, layanan, berita, dan profil desa.',
            image: $image ?? 'https://ridhokurniawan.my.id/img/rk.png'
        );

        return view('frontend.pages.profil.peta-desa');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        SeoHelper::set(
            title: 'Beranda - Website Resmi Desa',
            description: 'Website resmi Desa, menyediakan informasi publik, layanan, berita, dan profil desa.',
            image: $image ?? 'https://ridhokurniawan.my.id/img/rk.png'
        );

        return view('frontend.pages.home.index');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita; // Import Model Berita
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // 1. Data URL Statis (Halaman yang menunya tetap)
        // Sesuaikan string path-nya dengan Route di web.php kamu
        $urls = [
            url('/'),
            url('/profil/visi-misi'),
            url('/profil/sejarah'),
            url('/profil/perangkat'),
            url('/profil/peta'),
            url('/layanan/administrasi'),
            url('/layanan/produk-hukum'),
            url('/informasi/apbdes'),
            url('/informasi/pembangunan'),
            url('/kegiatan/galeri'),
            url('/kontak'),
            // Lembaga
            url('/lembaga/lpmd'),
            url('/lembaga/pkk'),
            url('/lembaga/karang-taruna'),
            url('/lembaga/posyandu'),
            url('/lembaga/bumdes'),
            url('/lembaga/koperasi-desa-merah-putih'),
            url('/kelembagaan/rt-rw'),
        ];

        // 2. Data URL Dinamis (Berita)
        // Kita loop semua berita agar Google tahu ada berita apa saja
        $beritas = Berita::latest()->get();

        foreach ($beritas as $berita) {
            // Asumsi route detail berita kamu adalah /berita/{slug}
            $urls[] = url('/berita/' . $berita->slug);
        }

        // 3. Return ke View dengan format XML
        return response()->view('frontend.sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }
}

<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Frontend\{
    AgendaController,
    BeritaController,
    DataController,
    GaleriController,
    HomeController,
    InformasiController,
    KontakController,
    LayananController,
    PemerintahanController,
    PengumumanController,
    PotensiController,
    ProfilController,
    SearchController,
    SitemapController,
    PosyanduController,
    LpmdController,
    ProdukHukumController,
    AdministrasiController,
    PkkController,
    BumdesController,
    KarangtarunaController,
    KdmpController
};
use Illuminate\Support\Facades\Route;

// Halaman Utama & Statis
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('profil.visimisi');
Route::get('/sejarah-desa', [ProfilController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/perangkat-desa', [ProfilController::class, 'perangkat'])->name('profil.perangkat');
Route::get('/peta-desa', [ProfilController::class, 'peta'])->name('profil.peta');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Administrasi Desa
Route::get('/administrasi', [AdministrasiController::class, 'index'])->name('administrasi.index');

// Produk Hukum Desa
Route::get('/produk-hukum', [ProdukHukumController::class, 'index'])->name('produk-hukum.index');

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Informasi Publik & Transparansi Desa
Route::prefix('informasi')->group(function () {
    Route::get('/apbdes', [InformasiController::class, 'apbdes'])->name('informasi.apbdes');
    Route::get('/apbdes/{tahun}', [InformasiController::class, 'apbdesTahun'])->name('informasi.apbdes.tahun');

    Route::get('/pembangunan', [InformasiController::class, 'pembangunan'])->name('informasi.pembangunan');
    Route::get('/pembangunan/{slug}', [InformasiController::class, 'pembangunanShow'])->name('informasi.pembangunan.show');
});

// Kontak & Pengaduan
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

// Lembaga Mitra Desa
Route::get('/lpmd', [LpmdController::class, 'index'])->name('lpmd.index');
Route::get('/posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
Route::get('/pkk', [PkkController::class, 'index'])->name('pkk.index');
Route::get('/bumdes', [BumdesController::class, 'index'])->name('bumdes.index');
Route::get('/karang-taruna', [KarangtarunaController::class, 'index'])->name('karangtaruna.index');
Route::get('/koperasi-desa-merah-putih', [KdmpController::class, 'index'])->name('koperasidesamerahputih.index');

// Halaman Sitemaps (SEO)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Admin Login Auth
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Page
Route::middleware(['auth', 'role:superadmin,admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

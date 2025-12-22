<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Frontend\{
    BeritaController,
    GaleriController,
    HomeController,
    InformasiController,
    KontakController,
    ProfilController,
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
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    PermissionController,
    LogActivityController,
    RoleController,
    UserController,
    AplikasiController,
    PesanController,
    GaleriAdminController,
    ApbdesController,
    PembangunanController,
    LpmdAdminController,
    PosyanduAdminController,
    PkkAdminController,
    BumdesAdminController,
    KarangTarunaAdminController,
    KdmpAdminController,
    AdministrasiAdminController,
    BeritaAdminController,
    ProdukHukumAdminController,
    VisiMisiController,
    SejarahController,
    PerangkatController,
    PetaController,
    BerandaController,
    SystemController
};
use Illuminate\Support\Facades\Route;

// ==========================================================
// GROUP FRONTEND (DIPASANG TRACKING VISITOR)
// ==========================================================
Route::middleware(['track.visitor'])->group(function () {
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
});

// ==========================================================
// ROUTE NON-TRACKING (ADMIN & AUTH)
// ==========================================================

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


// Admin Login Auth
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Page
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        // dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('permission:dashboard.view');

        // Beranda Desa Management
        Route::resource('/beranda', BerandaController::class)->names('admin.beranda')->middleware('permission:beranda.view');

        // Profil Desa Management
        Route::resource('/visi-misi', VisiMisiController::class)->names('admin.visiMisi')->middleware('permission:visi-misi.view');
        Route::resource('/sejarah', SejarahController::class)->names('admin.sejarah')->middleware('permission:sejarah.view');
        Route::resource('/perangkat', PerangkatController::class)->names('admin.perangkat')->middleware('permission:perangkat.view');
        Route::resource('/petadesa', PetaController::class)->names('admin.peta')->middleware('permission:peta.view');

        // Informasi Desa Management
        Route::resource('/administrasi', AdministrasiAdminController::class)->names('admin.administrasi')->middleware('permission:informasi.view');
        Route::resource('/berita', BeritaAdminController::class)->names('admin.berita')->middleware('permission:informasi.view');
        Route::resource('/produk', ProdukHukumAdminController::class)->names('admin.produk-hukum')->middleware('permission:informasi.view');

        // Lembaga Mitra Desa Management
        Route::resource('/lembaga/lpmd', LpmdAdminController::class)->names('admin.lpmd')->middleware('permission:lpmd.view');
        Route::resource('/lembaga/posyandu', PosyanduAdminController::class)->names('admin.posyandu')->middleware('permission:posyandu.view');
        Route::resource('/lembaga/pkk', PkkAdminController::class)->names('admin.pkk')->middleware('permission:pkk.view');
        Route::resource('/lembaga/bumdes', BumdesAdminController::class)->names('admin.bumdes')->middleware('permission:bumdes.view');
        Route::resource('/lembaga/karang-taruna', KarangTarunaAdminController::class)->middleware('permission:karang-taruna.view');
        Route::resource('/lembaga/koperasi', KdmpAdminController::class)->middleware('permission:koperasi.view');

        // Transparansi Management
        Route::resource('/transparansi/apbdes', ApbdesController::class)->middleware('permission:apbdes.view');
        Route::resource('/transparansi/pembangunan', PembangunanController::class)->middleware('permission:pembangunan.view');

        // Galeri Management
        Route::resource('admin/galeri', GaleriAdminController::class, ['as' => 'admin'])->middleware('permission:galeri.view');

        // Pesan Management
        Route::resource('/pesan', PesanController::class)->middleware('permission:pesan.view');
        Route::delete('/pesan-hapus-semua', [PesanController::class, 'destroyAll'])->middleware('permission:pesan.delete')->name('pesan.destroyAll');

        // Setting Management
        Route::resource('/setting/aplikasi', AplikasiController::class)->middleware('permission:aplikasi.view');
        Route::resource('/setting/user', UserController::class)->middleware('permission:user.view');
        Route::resource('/setting/roles', RoleController::class)->middleware('permission:roles.view');
        Route::resource('/setting/permissions', PermissionController::class)->middleware('permission:permissions.view');

        // Log Activity
        Route::get('/logactivity', [LogActivityController::class, 'index'])->name('admin.logactivity')->middleware('permission:logactivity.view');
        Route::delete('/logactivity/prune', [LogActivityController::class, 'prune'])->name('admin.logactivity.prune')->middleware('permission:logactivity.view');

        // Profile Admin
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
        Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');

        // Menampilkan halaman
        Route::get('/system', [SystemController::class, 'index'])->name('admin.system');
        Route::put('/system', [SystemController::class, 'update'])->name('admin.system.update');
    });

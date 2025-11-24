<?php

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
    PengaduanController,
    PengumumanController,
    PotensiController,
    ProfilController,
    SearchController,
    SitemapController,
    UmkmController
};
use Illuminate\Support\Facades\Route;

// Halaman Utama & Statis
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/profil-desa', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('profil.visimisi');
Route::get('/sejarah-desa', [ProfilController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/peta-desa', [ProfilController::class, 'peta'])->name('profil.peta');

// Pemerintahan Desa
Route::prefix('pemerintahan')->group(function () {
    Route::get('/', [PemerintahanController::class, 'index'])->name('pemdes.index');
    Route::get('/struktur-organisasi', [PemerintahanController::class, 'struktur'])->name('pemdes.struktur');
    Route::get('/perangkat-desa', [PemerintahanController::class, 'perangkat'])->name('pemdes.perangkat');
    Route::get('/bpd', [PemerintahanController::class, 'bpd'])->name('pemdes.bpd');
});

// Layanan Publik
Route::prefix('layanan')->group(function () {
    Route::get('/', [LayananController::class, 'index'])->name('layanan.index');

    // Pengajuan online
    Route::get('/surat', [LayananController::class, 'listSurat'])->name('layanan.surat');
    Route::get('/surat/{slug}', [LayananController::class, 'detailSurat'])->name('layanan.surat.detail');
    Route::post('/surat/{slug}/ajukan', [LayananController::class, 'ajukan'])->name('layanan.surat.ajukan');

    // Cek status
    Route::get('/cek-status', [LayananController::class, 'cekStatus'])->name('layanan.cekstatus');
    Route::post('/cek-status', [LayananController::class, 'doCekStatus'])->name('layanan.cekstatus.cari');
});

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Agenda
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{slug}', [AgendaController::class, 'show'])->name('agenda.show');

// Potensi Desa
Route::prefix('potensi')->group(function () {
    Route::get('/', [PotensiController::class, 'index'])->name('potensi.index');
    Route::get('/ekonomi', [PotensiController::class, 'ekonomi'])->name('potensi.ekonomi');
    Route::get('/wisata', [PotensiController::class, 'wisata'])->name('potensi.wisata');
    Route::get('/pertanian', [PotensiController::class, 'pertanian'])->name('potensi.pertanian');
    Route::get('/{slug}', [PotensiController::class, 'show'])->name('potensi.show');
});

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{slug}', [GaleriController::class, 'show'])->name('galeri.show');

// Informasi Publik & Transparansi Desa
Route::prefix('informasi')->group(function () {
    Route::get('/apbdes', [InformasiController::class, 'apbdes'])->name('informasi.apbdes');
    Route::get('/apbdes/{tahun}', [InformasiController::class, 'apbdesTahun'])->name('informasi.apbdes.tahun');

    Route::get('/dokumen', [InformasiController::class, 'dokumen'])->name('informasi.dokumen');
    Route::get('/dokumen/{slug}', [InformasiController::class, 'dokumenShow'])->name('informasi.dokumen.show');
});

// Data Desa
Route::prefix('data')->group(function () {
    Route::get('/', [DataController::class, 'index'])->name('data.index');
    Route::get('/penduduk', [DataController::class, 'penduduk'])->name('data.penduduk');
    Route::get('/pendidikan', [DataController::class, 'pendidikan'])->name('data.pendidikan');
    Route::get('/pekerjaan', [DataController::class, 'pekerjaan'])->name('data.pekerjaan');
    Route::get('/agama', [DataController::class, 'agama'])->name('data.agama');
    Route::get('/dusun', [DataController::class, 'dusun'])->name('data.dusun');
});

// UMKM / Produk Desa
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');

// Kontak & Pengaduan
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::post('/pengaduan/kirim', [PengaduanController::class, 'kirim'])->name('pengaduan.kirim');

// Halaman Pencarian
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Halaman Sitemaps (SEO)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

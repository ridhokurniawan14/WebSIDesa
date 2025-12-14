<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class BeritaController extends Controller
{
    private $data = [
        [
            'slug' => 'musrenbang-tahun-2025',
            'title' => 'Pemerintah Desa Laksanakan Musrenbang Tahun 2025',
            'date' => '12 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80',
            'excerpt' => 'Musyawarah perencanaan pembangunan desa telah dilaksanakan dengan melibatkan seluruh unsur masyarakat...',
            'content' => "
                <p>Musyawarah Perencanaan Pembangunan Desa (Musrenbang) tahun 2025 telah sukses dilaksanakan di balai desa.</p>
                <p>Kegiatan ini dihadiri oleh perangkat desa, tokoh masyarakat, ketua RT/RW, serta lembaga-lembaga desa.</p>
                <h3>Agenda Musrenbang</h3>
                <ul>
                    <li>Pemaparan program pembangunan</li>
                    <li>Diskusi prioritas pembangunan tahun berjalan</li>
                    <li>Usulan kegiatan dari warga</li>
                </ul>
                <p>Musrenbang desa merupakan langkah awal dalam menentukan arah pembangunan desa yang lebih baik.</p>
            "
        ],
        [
            'slug' => 'penyaluran-blt-tahap-awal',
            'title' => 'Penyaluran BLT Tahap Awal Berjalan Lancar',
            'date' => '8 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1581090464777-29a5d439a948?q=80',
            'excerpt' => 'Pemerintah Desa menyalurkan Bantuan Langsung Tunai kepada warga yang memenuhi syarat penerima manfaat...',
            'content' => "
                <p>Penyaluran BLT tahap awal berjalan dengan baik dan tertib.</p>
                <p>Pemerintah Desa memastikan semua penerima manfaat hadir dan menerima bantuan secara langsung.</p>
            "
        ],
        [
            'slug' => 'gotong-royong-jalan-desa',
            'title' => 'Gotong Royong Warga Dalam Pembenahan Jalan Desa',
            'date' => '2 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1581091012184-5c1d556f49c3?q=80',
            'excerpt' => 'Warga desa melaksanakan kegiatan gotong royong dalam rangka memperbaiki akses jalan yang rusak...',
            'content' => "
                <p>Kegiatan gotong royong dilakukan untuk memperbaiki jalan desa yang rusak akibat musim hujan.</p>
                <p>Warga terlihat antusias dan saling bekerja sama.</p>
            "
        ],
        [
            'slug' => 'posyandu-balita-sehat',
            'title' => 'Kegiatan Posyandu Balita Sehat Bulan Ini',
            'date' => '15 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1551818255-e6e10975bc17?q=80',
            'excerpt' => 'Kegiatan rutin posyandu balita kembali digelar untuk memantau tumbuh kembang anak...',
            'content' => "<p>Posyandu berjalan lancar dengan antusias ibu-ibu.</p>"
        ],
        [
            'slug' => 'pelatihan-umkm-desa',
            'title' => 'Pelatihan Digital Marketing untuk UMKM Desa',
            'date' => '18 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80',
            'excerpt' => 'Pemuda desa mengadakan pelatihan pemasaran online bagi pelaku usaha kecil...',
            'content' => "<p>Pelatihan ini bertujuan meningkatkan ekonomi warga.</p>"
        ],
        // --- DATA TAMBAHAN (Supaya total > 6) ---
        [
            'slug' => 'pemberdayaan-wanita-tani',
            'title' => 'Program Pemberdayaan Kelompok Wanita Tani',
            'date' => '20 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1625246333195-58197bd47d72?q=80',
            'excerpt' => 'Kelompok Wanita Tani (KWT) desa mulai mengembangkan kebun bibit sayuran organik...',
            'content' => "<p>Program ini diharapkan dapat menunjang ketahanan pangan keluarga.</p>"
        ],
        [
            'slug' => 'lomba-kebersihan-lingkungan',
            'title' => 'Lomba Kebersihan Lingkungan Antar RT',
            'date' => '22 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1560252829-804f1aedf1be?q=80',
            'excerpt' => 'Menyambut ulang tahun desa, diadakan lomba kebersihan lingkungan yang diikuti seluruh RT...',
            'content' => "<p>Warga berlomba-lomba mempercantik lingkungan mereka.</p>"
        ],
        [
            'slug' => 'panen-raya-padi',
            'title' => 'Panen Raya Padi Bersama Bupati',
            'date' => '25 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80',
            'excerpt' => 'Petani desa menyambut gembira panen raya tahun ini yang dihadiri langsung oleh Bupati...',
            'content' => "<p>Hasil panen tahun ini meningkat dibandingkan tahun sebelumnya.</p>"
        ],
    ];

    // ============================
    // INDEX (LIST BERITA)
    // ============================
    public function index(Request $request)
    {
        // 1. Ambil data mentah dan ubah jadi Collection
        $beritasCollection = collect($this->data);

        // 2. Logic PENCARIAN (Search)
        if ($request->has('search')) {
            $keyword = strtolower($request->search);
            $beritasCollection = $beritasCollection->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['title']), $keyword) ||
                    str_contains(strtolower($item['excerpt']), $keyword);
            });
        }

        // 3. Logic PAGINATION Manual
        $currentPage = Paginator::resolveCurrentPage() ?: 1;

        // UPDATE: Ubah dari 3 menjadi 6 sesuai permintaan
        $perPage = 6;

        $currentPageItems = $beritasCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Buat object Paginator agar bisa dipakai di View
        $beritas = new LengthAwarePaginator(
            $currentPageItems,
            $beritasCollection->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('frontend.pages.berita.index', compact('beritas'));
    }

    // ============================
    // DETAIL (SHOW)
    // ============================
    public function show($slug)
    {
        $berita = collect($this->data)->firstWhere('slug', $slug);

        if (!$berita) {
            abort(404);
        }

        $latest = collect($this->data)
            ->where('slug', '!=', $slug)
            ->take(5);

        return view('frontend.pages.berita.detail', compact('berita', 'latest'));
    }
}

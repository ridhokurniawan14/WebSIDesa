<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    ];



    // ============================
    // INDEX (LIST BERITA)
    // ============================
    public function index()
    {
        $beritas = $this->data;

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

        // berita terbaru (kecuali dirinya)
        $latest = collect($this->data)
            ->where('slug', '!=', $slug)
            ->take(5);

        return view('frontend.pages.berita.detail', compact('berita', 'latest'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PkkController extends Controller
{
    public function index()
    {
        // Data struktur pengurus
        $pengurus = [
            ['jabatan' => 'Ketua PKK', 'nama' => 'Ibu Siti Aminah', 'photo_url' => 'https://placehold.co/100x100/34D399/ffffff?text=SA'],
            ['jabatan' => 'Wakil Ketua', 'nama' => 'Ibu Nurhayati', 'photo_url' => 'https://placehold.co/100x100/059669/ffffff?text=NH'],
            ['jabatan' => 'Sekretaris', 'nama' => 'Ibu Dewi Lestari', 'photo_url' => 'https://placehold.co/100x100/10B981/ffffff?text=DL'],
            ['jabatan' => 'Bendahara', 'nama' => 'Ibu Rina Marlina', 'photo_url' => 'https://placehold.co/100x100/065F46/ffffff?text=RM'],
        ];

        // Daftar kegiatan
        $kegiatan = [
            'Posyandu Balita & Lansia',
            'Pelatihan Keterampilan Ibu Rumah Tangga',
            'Pembinaan UMKM Desa',
            'Penyuluhan Kesehatan Keluarga',
            'Kerja Bakti Lingkungan',
        ];

        // Daftar 10 Program Pokok PKK
        $program_pokok = [
            'Penghayatan dan Pengamalan Pancasila',
            'Gotong Royong',
            'Pangan',
            'Sandang',
            'Perumahan dan Tata Laksana Rumah Tangga',
            'Pendidikan dan Keterampilan',
            'Kesehatan',
            'Pengembangan Kehidupan Berkoperasi',
            'Kelestarian Lingkungan Hidup',
            'Perencanaan Sehat'
        ];

        return view('frontend.pages.pkk.index', compact('pengurus', 'kegiatan', 'program_pokok'));
    }
}

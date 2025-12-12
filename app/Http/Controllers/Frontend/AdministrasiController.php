<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class AdministrasiController extends Controller
{
    public function index()
    {
        $kategori = [
            'kependudukan' => 'Administrasi Kependudukan',
            'surat-keterangan' => 'Surat Keterangan',
            'lainnya' => 'Lainnya'
        ];

        // 8 DATA LAYANAN
        $layanan = collect([
            [
                'id' => 'kk',
                'kategori' => 'kependudukan',
                'nama' => 'Pembuatan Kartu Keluarga (KK)',
                'deskripsi' => 'Pengajuan pembuatan KK baru atau perubahan data.',
                'prosedur' => [
                    'Datang ke kantor desa dengan membawa persyaratan.',
                    'Mengisi formulir permohonan KK.',
                    'Verifikasi data oleh petugas.',
                    'Menunggu proses penerbitan KK.'
                ],
                'syarat' => [
                    'Fotokopi Buku Nikah',
                    'Fotokopi KTP suami & istri',
                    'Surat keterangan kelahiran anak',
                ]
            ],
            [
                'id' => 'ktp',
                'kategori' => 'kependudukan',
                'nama' => 'Pembuatan KTP-el',
                'deskripsi' => 'KTP elektronik untuk warga usia 17+.',
                'prosedur' => [
                    'Membawa dokumen persyaratan.',
                    'Pengambilan foto & sidik jari.',
                    'Menunggu pencetakan.'
                ],
                'syarat' => [
                    'Fotokopi KK',
                ]
            ],
            [
                'id' => 'sktm',
                'kategori' => 'surat-keterangan',
                'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'deskripsi' => 'Surat untuk bantuan sekolah, kesehatan, dan lainnya.',
                'prosedur' => [
                    'Mengisi formulir.',
                    'Verifikasi petugas.',
                    'Penerbitan surat.'
                ],
                'syarat' => [
                    'Fotokopi KK',
                    'Fotokopi KTP'
                ]
            ],
            [
                'id' => 'domisili',
                'kategori' => 'surat-keterangan',
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Persyaratan untuk berbagai kebutuhan administrasi.',
                'prosedur' => [
                    'Mengisi formulir domisili.',
                    'Pengecekan alamat oleh RT/RW.',
                    'Penerbitan surat oleh desa.'
                ],
                'syarat' => [
                    'Fotokopi KK',
                    'Fotokopi KTP'
                ]
            ],
            [
                'id' => 'usaha',
                'kategori' => 'surat-keterangan',
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Untuk pengajuan bantuan UMKM atau legalitas usaha.',
                'prosedur' => [
                    'Mengisi formulir SKU.',
                    'Verifikasi lapangan.',
                    'Penerbitan SKU.'
                ],
                'syarat' => [
                    'Fotokopi KTP',
                    'Fotokopi KK'
                ]
            ],
            [
                'id' => 'kematian',
                'kategori' => 'lainnya',
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Untuk kebutuhan data kependudukan dan administrasi lainnya.',
                'prosedur' => [
                    'Laporan keluarga.',
                    'Pengecekan data.',
                    'Penerbitan surat kematian.'
                ],
                'syarat' => [
                    'Fotokopi KK almarhum',
                    'Fotokopi KTP pelapor'
                ]
            ],
            [
                'id' => 'lahir',
                'kategori' => 'lainnya',
                'nama' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Untuk kebutuhan pembuatan Akta Kelahiran.',
                'prosedur' => [
                    'Laporan kelahiran.',
                    'Verifikasi data.',
                    'Penerbitan surat kelahiran.'
                ],
                'syarat' => [
                    'Surat keterangan dari bidan/RS',
                    'Fotokopi KK',
                ]
            ],
            [
                'id' => 'pindah',
                'kategori' => 'kependudukan',
                'nama' => 'Surat Pindah Penduduk',
                'deskripsi' => 'Untuk perpindahan penduduk antar desa atau kabupaten.',
                'prosedur' => [
                    'Mengisi formulir pindah.',
                    'Pengecekan data.',
                    'Penerbitan surat pindah.'
                ],
                'syarat' => [
                    'Fotokopi KK',
                    'Fotokopi KTP'
                ]
            ],
        ]);

        // PAGINATION MANUAL (6 per page)
        $perPage = 6;
        $currentPage = request()->get('page', 1);
        $pagedData = new LengthAwarePaginator(
            $layanan->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $layanan->count(),
            $perPage,
            $currentPage,
            ['path' => route('administrasi.index')]
        );

        return view('frontend.pages.administrasi-desa.index', [
            'layanan' => $pagedData,
            'kategori' => $kategori,
            'allLayanan' => $layanan // untuk modal
        ]);
    }
}

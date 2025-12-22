<?php

namespace App\Http\Controllers\Admin;

use App\Models\Beranda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil data pertama, atau null jika belum ada
        $beranda = Beranda::first();
        return view('admin.pages.beranda.index', compact('beranda'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        // Handle Banner Images
        $data['banner_images'] = $this->handleBannerUpload($request);

        $beranda = Beranda::create($data);

        // Activity Log
        activity('beranda')
            ->causedBy(auth()->user())
            ->performedOn($beranda)
            ->withProperties([
                'new_data' => $data,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan data beranda');

        return redirect()->route('admin.beranda.index')->with('success', 'Data Beranda berhasil dibuat!');
    }

    public function update(Request $request, Beranda $beranda)
    {
        $data = $this->validateRequest($request);

        // Handle Banner Images
        $data['banner_images'] = $this->handleBannerUpload($request);

        // Ambil data lama untuk log
        $oldData = $beranda->only([
            'deskripsi',
            'sambutan_kades',
            'periode_jabatan',
            'total_penduduk',
            'total_laki_laki',
            'total_perempuan',
            'usia_muda',
            'usia_dewasa',
            'usia_lansia',
            'jumlah_kk',
            'jumlah_rt',
            'jumlah_rw',
            'jumlah_dusun',
            'desa_adat',
            'keluarga_miskin',
            'banner_images'
        ]);

        $beranda->update($data);

        // Bandingkan perubahan
        $changes = [];
        foreach ($data as $key => $value) {
            if (($oldData[$key] ?? null) != $value) {
                $changes[$key] = [
                    'old' => $oldData[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        if (!empty($changes)) {
            activity('beranda')
                ->causedBy(auth()->user())
                ->performedOn($beranda)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data beranda');
        }

        return redirect()->route('admin.beranda.index')->with('success', 'Data Beranda berhasil diperbarui!');
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'deskripsi' => 'nullable|string',
            'sambutan_kades' => 'nullable|string',
            'periode_jabatan' => 'nullable|string',

            // Statistik
            'total_penduduk' => 'nullable|integer|min:0',
            'total_laki_laki' => 'nullable|integer|min:0',
            'total_perempuan' => 'nullable|integer|min:0',
            'usia_muda' => 'nullable|integer|min:0',
            'usia_dewasa' => 'nullable|integer|min:0',
            'usia_lansia' => 'nullable|integer|min:0',
            'jumlah_kk' => 'nullable|integer|min:0',
            'jumlah_rt' => 'nullable|integer|min:0',
            'jumlah_rw' => 'nullable|integer|min:0',
            'jumlah_dusun' => 'nullable|integer|min:0',
            'desa_adat' => 'nullable|integer|min:0',
            'keluarga_miskin' => 'nullable|integer|min:0',

            // Banner
            'banner' => 'array',
            'banner.*.gambar_file' => 'nullable|image|max:2048',
        ]);
    }

    private function handleBannerUpload($request)
    {
        $banners = [];
        if ($request->has('banner')) {
            foreach ($request->banner as $item) {
                if (isset($item['gambar_file']) && $item['gambar_file'] instanceof \Illuminate\Http\UploadedFile) {
                    $path = $item['gambar_file']->store('beranda/banners', 'public');
                    $banners[] = $path;
                } elseif (isset($item['gambar_old']) && !empty($item['gambar_old'])) {
                    $banners[] = $item['gambar_old'];
                }
            }
        }
        return $banners;
    }
}

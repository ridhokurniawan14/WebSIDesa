<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarangTaruna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KarangTarunaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pertama saja (karena ini profil lembaga)
        $karangTaruna = KarangTaruna::first();
        return view('admin.pages.karangtaruna.index', compact('karangTaruna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->saveData($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KarangTaruna $karangTaruna)
    {
        return $this->saveData($request, $karangTaruna);
    }

    /**
     * Logic penyimpanan dipisah biar rapi (DRY Pattern)
     */
    private function saveData($request, $model = null)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|array',
            'kontak' => 'nullable|array',
            'program' => 'nullable|array',
            'pengurus' => 'nullable|array',
            'galeri' => 'nullable|array',
        ]);

        // 1. Handle Upload Gambar Pengurus
        $pengurusFinal = [];
        if ($request->has('pengurus')) {
            foreach ($request->pengurus as $item) {
                $path = $item['gambar_old'] ?? null;

                if (isset($item['gambar_file']) && $item['gambar_file']->isValid()) {
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $path = $item['gambar_file']->store('karang-taruna/pengurus', 'public');
                }

                $pengurusFinal[] = [
                    'nama' => $item['nama'] ?? '',
                    'jabatan' => $item['jabatan'] ?? '',
                    'gambar' => $path,
                ];
            }
        }

        // 2. Handle Upload Galeri
        $galeriFinal = [];
        if ($request->has('galeri')) {
            foreach ($request->galeri as $item) {
                $path = $item['gambar_old'] ?? null;

                if (isset($item['gambar_file']) && $item['gambar_file']->isValid()) {
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $path = $item['gambar_file']->store('karang-taruna/galeri', 'public');
                }

                $galeriFinal[] = [
                    'judul' => $item['judul'] ?? '',
                    'gambar' => $path,
                ];
            }
        }

        // Data yang akan disimpan
        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'visi' => $request->visi,
            'misi' => $request->misi ?? [],
            'kontak' => $request->kontak ?? [],
            'program' => $request->program ?? [],
            'pengurus' => $pengurusFinal,
            'galeri' => $galeriFinal,
        ];

        if ($model) {
            // Ambil data lama untuk log
            $oldData = $model->only(['nama', 'deskripsi', 'visi', 'misi', 'kontak', 'program', 'pengurus', 'galeri']);

            $model->update($data);

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
                activity('karang_taruna')
                    ->causedBy(auth()->user())
                    ->performedOn($model)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah profil Karang Taruna');
            }
        } else {
            $karangTaruna = KarangTaruna::create($data);

            activity('karang_taruna')
                ->causedBy(auth()->user())
                ->performedOn($karangTaruna)
                ->withProperties([
                    'new_data' => $data,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Membuat profil Karang Taruna');
        }

        return redirect()->route('karang-taruna.index')->with('success', 'Data Karang Taruna berhasil disimpan!');
    }
}

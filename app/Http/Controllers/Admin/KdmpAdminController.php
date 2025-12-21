<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kdmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KdmpAdminController extends Controller
{
    /**
     * Menampilkan halaman profil koperasi (Logic Singleton)
     */
    public function index()
    {
        $koperasi = Kdmp::first();
        return view('admin.pages.koperasi.index', compact('koperasi'));
    }

    /**
     * Menyimpan data baru (Jika belum ada)
     */
    public function store(Request $request)
    {
        return $this->saveData($request);
    }

    /**
     * Mengupdate data (Jika sudah ada)
     */
    public function update(Request $request, Kdmp $koperasi)
    {
        return $this->saveData($request, $koperasi);
    }

    /**
     * Logic Simpan Data (Dipakai Store & Update)
     */
    private function saveData($request, $model = null)
    {
        // 1. Validasi
        $request->validate([
            'nama_koperasi'       => 'required|string|max:255',
            'deskripsi'           => 'required|string',
            'contact_person'      => 'required|string',
            'pengurus.*.nama'     => 'required|string',
            'pengurus.*.jabatan'  => 'required|string',
            'pengurus.*.foto_file' => 'nullable|image|max:2048',
        ]);

        // 2. Handle Upload Foto Pengurus
        $pengurusFinal = [];
        if ($request->has('pengurus')) {
            foreach ($request->pengurus as $key => $val) {
                $path = $val['foto_old'] ?? null;

                if ($request->hasFile("pengurus.$key.foto_file")) {
                    $file = $request->file("pengurus.$key.foto_file");
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $path = $file->store('koperasi/pengurus', 'public');
                }

                $pengurusFinal[] = [
                    'nama'    => $val['nama'],
                    'jabatan' => $val['jabatan'],
                    'foto'    => $path,
                ];
            }
        }

        // 3. Handle Syarat Anggota
        $syaratFinal = array_filter($request->syarat ?? [], fn($v) => !is_null($v) && $v !== '');

        // 4. Data yang akan disimpan
        $dataToSave = [
            'nama_koperasi'     => $request->nama_koperasi,
            'deskripsi'         => $request->deskripsi,
            'contact_person'    => $request->contact_person,
            'struktur_pengurus' => $pengurusFinal,
            'syarat_anggota'    => array_values($syaratFinal),
        ];

        if ($model) {
            // Ambil data lama untuk log
            $oldData = $model->only(['nama_koperasi', 'deskripsi', 'contact_person', 'struktur_pengurus', 'syarat_anggota']);

            $model->update($dataToSave);

            // Bandingkan perubahan
            $changes = [];
            foreach ($dataToSave as $key => $value) {
                if (($oldData[$key] ?? null) != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key] ?? null,
                        'new' => $value,
                    ];
                }
            }

            if (!empty($changes)) {
                activity('koperasi')
                    ->causedBy(auth()->user())
                    ->performedOn($model)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah profil Koperasi Desa');
            }
        } else {
            $koperasi = Kdmp::create($dataToSave);

            activity('koperasi')
                ->causedBy(auth()->user())
                ->performedOn($koperasi)
                ->withProperties([
                    'new_data' => $dataToSave,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Membuat profil Koperasi Desa');
        }

        return redirect()->route('koperasi.index')->with('success', 'Data Koperasi Desa berhasil disimpan!');
    }
}

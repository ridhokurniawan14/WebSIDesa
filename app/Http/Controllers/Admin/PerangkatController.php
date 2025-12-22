<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerangkatController extends Controller
{
    public function index()
    {
        // Ambil data pertama (karena konsepnya single record per desa)
        $perangkat = Perangkat::first();

        return view('admin.pages.perangkatdesa.index', compact('perangkat'));
    }

    public function store(Request $request)
    {
        return $this->saveData($request);
    }

    public function update(Request $request, Perangkat $perangkat)
    {
        return $this->saveData($request, $perangkat);
    }

    private function saveData($request, $model = null)
    {
        $request->validate([
            'foto_struktur' => 'nullable|image|max:2048',
            'staff' => 'required|array',
            'staff.*.nama' => 'required|string',
            'staff.*.jabatan' => 'required|string',
            'staff.*.foto_new' => 'nullable|image|max:1024',
        ]);

        // 1. Handle Foto Struktur Utama
        $pathStruktur = $model ? $model->foto_struktur_organisasi : null;
        if ($request->hasFile('foto_struktur')) {
            if ($model && $model->foto_struktur_organisasi) {
                Storage::disk('public')->delete($model->foto_struktur_organisasi);
            }
            $pathStruktur = $request->file('foto_struktur')->store('perangkat-desa', 'public');
        }

        // 2. Handle Data Staff
        $staffData = [];
        if ($request->has('staff')) {
            foreach ($request->input('staff') as $index => $data) {
                $fotoPath = $data['foto_old'] ?? null;

                if ($request->hasFile("staff.{$index}.foto_new")) {
                    $fotoPath = $request->file("staff.{$index}.foto_new")->store('perangkat-desa/staff', 'public');

                    if (isset($data['foto_old']) && !str_contains($data['foto_old'], 'http')) {
                        Storage::disk('public')->delete($data['foto_old']);
                    }
                }

                $staffData[] = [
                    'nama' => $data['nama'],
                    'jabatan' => $data['jabatan'],
                    'foto' => $fotoPath,
                ];
            }
        }

        $dataToSave = [
            'foto_struktur_organisasi' => $pathStruktur,
            'data_perangkat' => $staffData,
        ];

        if ($model) {
            $oldData = $model->only(['foto_struktur_organisasi', 'data_perangkat']);
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
                activity('perangkat')
                    ->causedBy(auth()->user())
                    ->performedOn($model)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah data perangkat desa');
            }
        } else {
            $perangkat = Perangkat::create($dataToSave);

            activity('perangkat')
                ->causedBy(auth()->user())
                ->performedOn($perangkat)
                ->withProperties([
                    'new_data' => $dataToSave,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Membuat data perangkat desa');
        }

        return redirect()->route('admin.perangkat.index')->with('success', 'Data Perangkat Desa berhasil diperbarui!');
    }
}

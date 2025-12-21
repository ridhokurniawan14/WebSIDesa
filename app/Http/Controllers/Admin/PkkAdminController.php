<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pkk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PkkAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pertama saja karena konsepnya Single Page Profile
        $pkk = Pkk::first();
        return view('admin.pages.pkk.index', compact('pkk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('pkk.create'); // Permission check
        return $this->saveData($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pkk $pkk)
    {
        $this->authorize('pkk.update'); // Permission check
        return $this->saveData($request, $pkk);
    }

    /**
     * Logika Penyimpanan (Dipakai store & update)
     */
    private function saveData($request, $pkk = null)
    {
        // 1. Validasi
        $data = $request->validate([
            'nama_ketua'        => 'nullable|string|max:255',
            'nomor_hp_wa'       => 'nullable|string|max:20',
            'gambar_ilustrasi'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi_singkat' => 'nullable|string',

            // Validasi Array JSON
            'pengurus'            => 'array',
            'pengurus.*.nama'     => 'required|string',
            'pengurus.*.jabatan'  => 'required|string',

            'kegiatan'         => 'array',
            'program_pokok'    => 'array',
        ]);

        // 2. Handle Upload Gambar Ilustrasi Utama
        if ($request->hasFile('gambar_ilustrasi')) {
            if ($pkk && $pkk->gambar_ilustrasi) {
                Storage::disk('public')->delete($pkk->gambar_ilustrasi);
            }
            $data['gambar_ilustrasi'] = $request->file('gambar_ilustrasi')->store('pkk/ilustrasi', 'public');
        } else {
            unset($data['gambar_ilustrasi']);
        }

        // 3. Handle Upload Foto Pengurus (Inside Repeater)
        $pengurusFinal = [];
        if ($request->has('pengurus')) {
            foreach ($request->pengurus as $index => $item) {
                $photoPath = $item['photo_url_old'] ?? null;

                if ($request->hasFile("pengurus.$index.photo_file")) {
                    if ($photoPath) {
                        Storage::disk('public')->delete($photoPath);
                    }
                    $photoPath = $request->file("pengurus.$index.photo_file")->store('pkk/pengurus', 'public');
                }

                $pengurusFinal[] = [
                    'jabatan'   => $item['jabatan'],
                    'nama'      => $item['nama'],
                    'photo_url' => $photoPath,
                ];
            }
        }
        $data['pengurus'] = $pengurusFinal;

        // 4. Bersihkan Array Kegiatan & Program
        $data['kegiatan'] = array_filter($request->kegiatan ?? [], fn($v) => !is_null($v) && $v !== '');
        $data['program_pokok'] = array_filter($request->program_pokok ?? [], fn($v) => !is_null($v) && $v !== '');

        // 5. Simpan Data + Activity Log
        if ($pkk) {
            $oldData = $pkk->only([
                'nama_ketua',
                'nomor_hp_wa',
                'gambar_ilustrasi',
                'deskripsi_singkat',
                'pengurus',
                'kegiatan',
                'program_pokok'
            ]);

            $pkk->update($data);

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
                activity('pkk')
                    ->causedBy(auth()->user())
                    ->performedOn($pkk)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah profil PKK');
            }
        } else {
            $pkk = Pkk::create($data);

            activity('pkk')
                ->causedBy(auth()->user())
                ->performedOn($pkk)
                ->withProperties([
                    'new_data' => $data,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Membuat profil PKK');
        }

        return redirect()->route('admin.pkk.index')->with('success', 'Data PKK berhasil diperbarui!');
    }
}

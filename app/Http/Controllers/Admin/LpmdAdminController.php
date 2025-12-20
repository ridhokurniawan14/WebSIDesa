<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lpmd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LpmdAdminController extends Controller
{
    public function index()
    {
        // Ambil satu data saja (karena LPMD cuma 1 per desa)
        $lpmd = Lpmd::first();

        return view('admin.pages.lpmd.index', compact('lpmd'));
    }

    public function store(Request $request)
    {
        // Cek permission
        if (!auth()->user()->can('lpmd.create')) {
            abort(403, 'Unauthorized');
        }

        // Validasi: Cek apakah data sudah ada? Jika ada, block store (harus update)
        if (Lpmd::count() > 0) {
            return redirect()->back()->with('error', 'Data LPMD sudah ada. Silakan edit data yang sudah ada.');
        }

        $data = $this->validateRequest($request);

        // Handle Upload Gambar
        if ($request->hasFile('struktur_gambar')) {
            $data['struktur_gambar'] = $request->file('struktur_gambar')->store('lpmd', 'public');
        }

        $lpmd = Lpmd::create($data);

        // Activity Log
        activity('lpmd')
            ->causedBy(auth()->user())
            ->performedOn($lpmd)
            ->withProperties([
                'new_data' => $data,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Membuat profil LPMD');

        return redirect()->route('admin.lpmd.index')->with('success', 'Data LPMD berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('lpmd.update')) {
            abort(403, 'Unauthorized');
        }

        $lpmd = Lpmd::findOrFail($id);
        $oldData = $lpmd->only([
            'deskripsi',
            'dasar_hukum',
            'tugas_fungsi',
            'struktur_gambar',
            'ketua',
            'sekretaris',
            'bendahara',
            'bidang',
            'program'
        ]);

        $data = $this->validateRequest($request);

        // Handle Ganti Gambar
        if ($request->hasFile('struktur_gambar')) {
            // Hapus gambar lama
            if ($lpmd->struktur_gambar && Storage::disk('public')->exists($lpmd->struktur_gambar)) {
                Storage::disk('public')->delete($lpmd->struktur_gambar);
            }
            $data['struktur_gambar'] = $request->file('struktur_gambar')->store('lpmd', 'public');
        }

        $lpmd->update($data);

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
            activity('lpmd')
                ->causedBy(auth()->user())
                ->performedOn($lpmd)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah profil LPMD');
        }

        return redirect()->route('admin.lpmd.index')->with('success', 'Data LPMD berhasil diperbarui');
    }

    // Private method biar validasinya tidak ditulis ulang 2x
    private function validateRequest($request)
    {
        return $request->validate([
            'deskripsi'       => 'required',
            'dasar_hukum'     => 'nullable|array',
            'tugas_fungsi'    => 'nullable|array',
            'struktur_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ketua'           => 'required|string',
            'sekretaris'      => 'required|string',
            'bendahara'       => 'required|string',
            'bidang'          => 'nullable|array',
            'program'         => 'nullable|array',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Posyandu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosyanduAdminController extends Controller
{
    public function __construct()
    {
        // Middleware Permission sesuai request
        $this->middleware('permission:posyandu.view')->only('index');
        $this->middleware('permission:posyandu.create')->only('store');
        $this->middleware('permission:posyandu.update')->only('update');
        $this->middleware('permission:posyandu.delete')->only('destroy');
    }

    public function index()
    {
        // Ambil data pertama saja (Single Profile Logic)
        $posyandu = Posyandu::first();
        return view('admin.pages.posyandu.index', compact('posyandu'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        // Handle Upload Gambar
        if ($request->hasFile('gambar_struktur')) {
            $data['gambar_struktur'] = $request->file('gambar_struktur')->store('posyandu', 'public');
        }

        $posyandu = Posyandu::create($data);

        // Activity Log
        activity('posyandu')
            ->causedBy(auth()->user())
            ->performedOn($posyandu)
            ->withProperties([
                'new_data' => $data,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Membuat profil Posyandu');

        return redirect()->back()->with('success', 'Data Posyandu berhasil dibuat!');
    }

    public function update(Request $request, Posyandu $posyandu)
    {
        $oldData = $posyandu->only([
            'deskripsi',
            'jadwal',
            'nama_ketua',
            'nama_sekretaris',
            'nama_bendahara',
            'tujuan',
            'layanan',
            'sasaran',
            'program',
            'nama_kader',
            'kontak',
            'gambar_struktur'
        ]);

        $data = $this->validateRequest($request);

        // Handle Upload Gambar (Hapus lama, simpan baru)
        if ($request->hasFile('gambar_struktur')) {
            if ($posyandu->gambar_struktur && Storage::disk('public')->exists($posyandu->gambar_struktur)) {
                Storage::disk('public')->delete($posyandu->gambar_struktur);
            }
            $data['gambar_struktur'] = $request->file('gambar_struktur')->store('posyandu', 'public');
        }

        $posyandu->update($data);

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
            activity('posyandu')
                ->causedBy(auth()->user())
                ->performedOn($posyandu)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah profil Posyandu');
        }

        return redirect()->back()->with('success', 'Data Posyandu berhasil diperbarui!');
    }

    public function destroy(Posyandu $posyandu)
    {
        // Ambil data lama sebelum dihapus
        $oldData = $posyandu->only([
            'deskripsi',
            'jadwal',
            'nama_ketua',
            'nama_sekretaris',
            'nama_bendahara',
            'tujuan',
            'layanan',
            'sasaran',
            'program',
            'nama_kader',
            'kontak',
            'gambar_struktur'
        ]);

        // Hapus gambar jika ada
        if ($posyandu->gambar_struktur && Storage::disk('public')->exists($posyandu->gambar_struktur)) {
            Storage::disk('public')->delete($posyandu->gambar_struktur);
        }

        $posyandu->delete();

        // Activity Log
        activity('posyandu')
            ->causedBy(auth()->user())
            ->performedOn($posyandu)
            ->withProperties([
                'deleted_data' => $oldData,
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus profil Posyandu');

        return redirect()->back()->with('success', 'Data berhasil direset!');
    }

    // Fungsi Validasi biar rapi
    private function validateRequest($request)
    {
        return $request->validate([
            'deskripsi' => 'required|string',
            'jadwal' => 'nullable|string',

            // String Fields
            'nama_ketua' => 'nullable|string',
            'nama_sekretaris' => 'nullable|string',
            'nama_bendahara' => 'nullable|string',

            // JSON Fields (Array)
            'tujuan' => 'nullable|array',
            'tujuan.*' => 'nullable|string',

            'layanan' => 'nullable|array',
            'layanan.*' => 'nullable|string',

            'sasaran' => 'nullable|array',
            'sasaran.*' => 'nullable|string',

            'program' => 'nullable|array',
            'program.*' => 'nullable|string',

            'nama_kader' => 'nullable|array',
            'nama_kader.*' => 'nullable|string',

            // Complex JSON (Kontak)
            'kontak' => 'nullable|array',
            'kontak.*.nama' => 'nullable|string',
            'kontak.*.jabatan' => 'nullable|string',
            'kontak.*.telepon' => 'nullable|string',

            'gambar_struktur' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
}

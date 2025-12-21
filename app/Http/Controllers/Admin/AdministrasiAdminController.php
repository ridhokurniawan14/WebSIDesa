<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdministrasiAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $kategori = $request->kategori;

        $query = Administrasi::query();

        if ($q) {
            $query->where('nama', 'like', '%' . $q . '%');
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        $categories = [
            'kependudukan' => 'Administrasi Kependudukan',
            'surat-keterangan' => 'Surat Keterangan',
            'lainnya' => 'Lainnya'
        ];

        return view('admin.pages.administrasi.index', compact('data', 'categories'));
    }

    public function create()
    {
        return view('admin.pages.administrasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'prosedur' => 'nullable|array',
            'prosedur.*' => 'nullable|string',
            'syarat' => 'nullable|array',
            'syarat.*' => 'nullable|string',
        ]);

        $prosedur = array_values(array_filter($request->prosedur ?? [], fn($v) => !is_null($v) && $v !== ''));
        $syarat = array_values(array_filter($request->syarat ?? [], fn($v) => !is_null($v) && $v !== ''));

        $administrasi = Administrasi::create([
            'slug' => Str::slug($request->nama) . '-' . Str::random(5),
            'kategori' => $request->kategori,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'prosedur' => $prosedur,
            'syarat' => $syarat,
        ]);

        // Activity Log
        activity('administrasi')
            ->causedBy(auth()->user())
            ->performedOn($administrasi)
            ->withProperties([
                'new_data' => $administrasi->toArray(),
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan layanan administrasi baru');

        return redirect()->route('admin.administrasi.index')
            ->with('success', 'Layanan administrasi berhasil ditambahkan');
    }

    public function show(Administrasi $administrasi)
    {
        // Tidak dipakai
    }

    public function edit($id)
    {
        $administrasi = Administrasi::findOrFail($id);
        return view('admin.pages.administrasi.edit', compact('administrasi'));
    }

    public function update(Request $request, $id)
    {
        $administrasi = Administrasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'prosedur' => 'nullable|array',
            'syarat' => 'nullable|array',
        ]);

        $prosedur = array_values(array_filter($request->prosedur ?? [], fn($v) => !is_null($v) && $v !== ''));
        $syarat = array_values(array_filter($request->syarat ?? [], fn($v) => !is_null($v) && $v !== ''));

        $oldData = $administrasi->only(['slug', 'kategori', 'nama', 'deskripsi', 'prosedur', 'syarat']);

        $administrasi->update([
            'slug' => Str::slug($request->nama) . '-' . Str::random(5),
            'kategori' => $request->kategori,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'prosedur' => $prosedur,
            'syarat' => $syarat,
        ]);

        // Bandingkan perubahan
        $changes = [];
        foreach (['slug', 'kategori', 'nama', 'deskripsi', 'prosedur', 'syarat'] as $field) {
            if (($oldData[$field] ?? null) != $administrasi->$field) {
                $changes[$field] = [
                    'old' => $oldData[$field] ?? null,
                    'new' => $administrasi->$field,
                ];
            }
        }

        if (!empty($changes)) {
            activity('administrasi')
                ->causedBy(auth()->user())
                ->performedOn($administrasi)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah layanan administrasi');
        }

        return redirect()->route('admin.administrasi.index')
            ->with('success', 'Data layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $administrasi = Administrasi::findOrFail($id);

        $oldData = $administrasi->toArray();
        $administrasi->delete();

        // Activity Log
        activity('administrasi')
            ->causedBy(auth()->user())
            ->performedOn($administrasi)
            ->withProperties([
                'deleted_data' => $oldData,
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus layanan administrasi');

        return redirect()->route('admin.administrasi.index')
            ->with('success', 'Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProdukHukum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukHukumAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = ProdukHukum::query();

        // 1. Filter Pencarian (Judul)
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // 2. Filter Jenis (Dropdown)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // 3. Filter Tahun (Dropdown)
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data tahun unik dari DB untuk dropdown filter
        $years = ProdukHukum::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $produkHukum = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pages.produkhukum.index', compact('produkHukum', 'years'));
    }

    // ... method store, update, destroy tetap sama seperti sebelumnya ...
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:Peraturan Desa,Peraturan Kepala Desa,Keputusan Kepala Desa,Surat Edaran',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'file'  => 'required|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['judul', 'jenis', 'tahun']);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('produk-hukum', 'public');
        }

        $produkHukum = ProdukHukum::create($data);

        // Activity Log
        if (function_exists('activity')) {
            activity('produk_hukum')
                ->causedBy(auth()->user())
                ->performedOn($produkHukum)
                ->withProperties([
                    'new_data' => $data,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Menambahkan produk hukum baru');
        }

        return redirect()->back()->with('success', 'Produk hukum berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $produkHukum = ProdukHukum::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:Peraturan Desa,Peraturan Kepala Desa,Keputusan Kepala Desa,Surat Edaran',
            'tahun' => 'required|digits:4|integer',
            'file'  => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $oldData = $produkHukum->only(['judul', 'jenis', 'tahun', 'file']);
        $data = $request->only(['judul', 'jenis', 'tahun']);

        if ($request->hasFile('file')) {
            if ($produkHukum->file && Storage::disk('public')->exists($produkHukum->file)) {
                Storage::disk('public')->delete($produkHukum->file);
            }
            $data['file'] = $request->file('file')->store('produk-hukum', 'public');
        }

        $produkHukum->update($data);

        return redirect()->back()->with('success', 'Produk hukum berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produkHukum = ProdukHukum::findOrFail($id);

        if ($produkHukum->file && Storage::disk('public')->exists($produkHukum->file)) {
            Storage::disk('public')->delete($produkHukum->file);
        }

        $produkHukum->delete();

        return redirect()->back()->with('success', 'Produk hukum berhasil dihapus.');
    }
}

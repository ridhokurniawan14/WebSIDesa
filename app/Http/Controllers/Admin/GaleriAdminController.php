<?php

namespace App\Http\Controllers\Admin;

use App\Models\Galeri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GaleriAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Galeri::query();

        if ($request->has('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $galeris = $query->latest('tanggal')->paginate(10);

        return view('admin.pages.galeri.index', compact('galeris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi standar tanpa custom message array
        $request->validate([
            'judul'   => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar'  => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['judul', 'tanggal']);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = $path;
        }

        Galeri::create($data);

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User menambahkan galeri baru: ' . $request->judul);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul'   => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Ambil data lama sebelum update
        $oldData = $galeri->only(['judul', 'tanggal', 'gambar']);

        $data = $request->only(['judul', 'tanggal']);

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = $path;
        }

        $galeri->update($data);

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

        // Simpan activity log hanya jika ada perubahan
        if (!empty($changes)) {
            activity('galeri')
                ->causedBy(auth()->user())
                ->performedOn($galeri)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data galeri');
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus galeri: ' . $galeri->judul);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }
}

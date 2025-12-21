<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        // Logic Search
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Order by terbaru
        $beritas = $query->latest('date')->paginate(10)->withQueryString();

        // Pastikan path view ini sesuai dengan struktur folder kamu
        return view('admin.pages.berita.index', compact('beritas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'date'      => 'required|date',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'   => 'nullable|string|max:255',
            'content'   => 'required',
        ]);

        // Upload Gambar
        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('berita', 'public');
        }

        $berita = Berita::create([
            'slug'      => Str::slug($request->title) . '-' . Str::random(5),
            'title'     => $request->title,
            'date'      => $request->date,
            'thumbnail' => $imagePath,
            'excerpt'   => $request->excerpt,
            'content'   => $request->content,
        ]);

        // Activity Log (Jika pakai Spatie)
        if (function_exists('activity')) {
            activity('berita')
                ->causedBy(auth()->user())
                ->performedOn($berita)
                ->withProperties([
                    'new_data' => $berita->toArray(),
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Menambahkan berita baru');
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    // Ubah parameter jadi $id biar aman
    public function update(Request $request, string $id)
    {
        // Cari manual by ID
        $berita = Berita::findOrFail($id);

        $request->validate([
            'title'     => 'required|string|max:255',
            'date'      => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'   => 'nullable|string|max:255',
            'content'   => 'required',
        ]);

        $oldData = $berita->only(['title', 'slug', 'date', 'excerpt', 'content', 'thumbnail']);

        $data = [
            'title'   => $request->title,
            'slug'    => Str::slug($request->title) . '-' . Str::random(5),
            'date'    => $request->date,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        }

        $berita->update($data);

        // Activity Log Logic
        if (function_exists('activity')) {
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
                activity('berita')
                    ->causedBy(auth()->user())
                    ->performedOn($berita)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah berita');
            }
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    // Ubah parameter jadi $id biar aman
    public function destroy(string $id)
    {
        // Cari manual by ID
        $berita = Berita::findOrFail($id);

        $oldData = $berita->toArray();

        if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        $berita->delete();

        // Activity Log
        if (function_exists('activity')) {
            activity('berita')
                ->causedBy(auth()->user())
                ->performedOn($berita)
                ->withProperties([
                    'deleted_data' => $oldData,
                    'ip' => request()->ip(),
                    'method' => request()->method(),
                ])
                ->log('Menghapus berita');
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }
}

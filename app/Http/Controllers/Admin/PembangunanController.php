<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pembangunan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PembangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembangunan::query();

        // 1. Search by Judul
        if ($request->has('q') && $request->q != '') {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // 2. Filter Tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // 3. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(10);

        // Ambil list tahun unik dari DB untuk dropdown filter
        $years = Pembangunan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.pages.pembangunan.index', compact('data', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pastikan punya permission
        $this->authorize('pembangunan.create');
        return view('admin.pages.pembangunan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('pembangunan.create');

        $request->validate([
            'judul'       => 'required|string|max:255',
            'desa'        => 'required|string',
            'lokasi'      => 'required|string',
            'volume'      => 'required|string',
            'anggaran'    => 'required|numeric',
            'sumber_dana' => 'required|string',
            'tahun'       => 'required|digits:4',
            'pelaksana'   => 'required|string',
            'status'      => 'required|string',
            'foto'        => 'array|max:5', // Maksimal 5 file
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048', // Max 2MB per foto
        ]);

        $data = $request->except('foto');

        // Generate Slug dari Judul + Random String biar unik
        $data['slug'] = Str::slug($request->judul) . '-' . Str::random(5);

        // Logic Upload Foto Multiple
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                // Simpan ke folder 'public/pembangunan'
                $fotoPaths[] = $file->store('pembangunan', 'public');
            }
        }

        // Simpan array path ke database (otomatis jadi JSON karena casting di Model)
        $data['foto'] = $fotoPaths;

        $pembangunan = Pembangunan::create($data);

        // Simpan activity log
        activity('pembangunan')
            ->causedBy(auth()->user())
            ->performedOn($pembangunan)
            ->withProperties([
                'new_data' => $data,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan data pembangunan baru');

        return redirect()->route('pembangunan.index')->with('success', 'Data pembangunan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembangunan $pembangunan)
    {
        // Opsional jika butuh detail view admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembangunan $pembangunan)
    {
        $this->authorize('pembangunan.update');
        return view('admin.pages.pembangunan.edit', compact('pembangunan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembangunan $pembangunan)
    {
        $this->authorize('pembangunan.update');

        $request->validate([
            'judul'       => 'required|string|max:255',
            'desa'        => 'required|string',
            'anggaran'    => 'required|numeric',
            'foto'        => 'array|max:5',
            'foto.*'      => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filesToKeep = $request->input('existing_foto', []);

        // (Opsional) Hapus file fisik yang tidak ada di list $filesToKeep
        // $allOldFiles = $pembangunan->foto ?? [];
        // $diff = array_diff($allOldFiles, $filesToKeep);
        // foreach($diff as $del) Storage::disk('public')->delete($del);

        // Proses Foto Baru (jika ada)
        $newFilesPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $newFilesPaths[] = $file->store('pembangunan', 'public');
            }
        }

        // Gabungkan: Foto Lama yg Dipertahankan + Foto Baru
        $finalPhotos = array_merge($filesToKeep, $newFilesPaths);

        // Ambil data lama sebelum update
        $oldData = $pembangunan->only(['judul', 'desa', 'anggaran', 'foto']);

        // Simpan
        $data = $request->except(['foto', 'existing_foto']);
        $data['foto'] = $finalPhotos; // array otomatis jadi json krn casting di Model

        $pembangunan->update($data);

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
            activity('pembangunan')
                ->causedBy(auth()->user())
                ->performedOn($pembangunan)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data pembangunan');
        }

        return redirect()->route('pembangunan.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembangunan $pembangunan)
    {
        $this->authorize('pembangunan.delete');

        // Ambil data lama sebelum dihapus (buat log)
        $oldData = $pembangunan->only(['judul', 'desa', 'anggaran', 'foto']);

        // Hapus file fisik dulu
        if ($pembangunan->foto) {
            foreach ($pembangunan->foto as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $pembangunan->delete();

        // Simpan activity log
        activity('pembangunan')
            ->causedBy(auth()->user())
            ->performedOn($pembangunan)
            ->withProperties([
                'deleted_data' => $oldData,
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus data pembangunan');

        return redirect()->route('pembangunan.index')->with('success', 'Data berhasil dihapus');
    }
}

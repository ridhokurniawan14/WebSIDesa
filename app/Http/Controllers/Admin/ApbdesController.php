<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apbdes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApbdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Apbdes::query();

        // Filter Tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Filter Jenis
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        // Fitur Search Uraian
        if ($request->has('q') && $request->q != '') {
            $query->where('uraian', 'like', '%' . $request->q . '%');
        }

        // Ambil data tahun unik untuk filter dropdown
        $years = Apbdes::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // Urutkan berdasarkan tahun terbaru, lalu dibuat
        $data = $query->orderBy('tahun', 'desc')->latest()->paginate(10);

        return view('admin.pages.apbdes.index', compact('data', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uraian'    => 'required|string|max:255',
            'jenis'     => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'anggaran'  => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'tahun'     => 'required|integer|digits:4',
        ]);

        // --- LOGIC TAMBAHAN START ---
        // Cek jika user memilih jenis 'Pembiayaan'
        if ($validated['jenis'] === 'Pembiayaan') {
            // Hitung berapa kali 'Pembiayaan' sudah diinput di tahun tersebut
            $jumlahPembiayaan = Apbdes::where('jenis', 'Pembiayaan')
                ->where('tahun', $validated['tahun'])
                ->count();

            // Jika sudah ada 2 atau lebih, tolak inputan
            if ($jumlahPembiayaan >= 2) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal! Jenis Pembiayaan hanya boleh diinput maksimal 2 kali dalam tahun ' . $validated['tahun']);
            }
        }
        // --- LOGIC TAMBAHAN END ---

        $apbdes = Apbdes::create($validated);

        // Simpan activity log
        activity('apbdes')
            ->causedBy(auth()->user())
            ->performedOn($apbdes)
            ->withProperties([
                'new_data' => $validated,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan data APBDes baru');

        return redirect()->route('apbdes.index')->with('success', 'Data APBDes berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari data manual berdasarkan ID
        $apbdes = Apbdes::findOrFail($id);

        $validated = $request->validate([
            'uraian'    => 'required|string|max:255',
            'jenis'     => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'anggaran'  => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'tahun'     => 'required|integer|digits:4',
        ]);

        // --- LOGIC TAMBAHAN START ---
        if ($validated['jenis'] === 'Pembiayaan') {
            // Hitung jumlah data lain (selain data ini) yang jenisnya Pembiayaan di tahun tsb
            $jumlahPembiayaanLain = Apbdes::where('jenis', 'Pembiayaan')
                ->where('tahun', $validated['tahun'])
                ->where('id', '!=', $id) // PENTING: Jangan hitung diri sendiri agar bisa diedit
                ->count();

            if ($jumlahPembiayaanLain >= 2) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal! Jenis Pembiayaan hanya boleh diinput maksimal 2 kali dalam tahun ' . $validated['tahun']);
            }
        }
        // --- LOGIC TAMBAHAN END ---

        // Ambil data lama sebelum update
        $oldData = $apbdes->only(['uraian', 'jenis', 'anggaran', 'realisasi', 'tahun']);

        // Update data
        $apbdes->update($validated);

        // Bandingkan perubahan
        $changes = [];
        foreach ($validated as $key => $value) {
            if (($oldData[$key] ?? null) != $value) {
                $changes[$key] = [
                    'old' => $oldData[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        // Simpan activity log hanya jika ada perubahan
        if (!empty($changes)) {
            activity('apbdes')
                ->causedBy(auth()->user())
                ->performedOn($apbdes)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data APBDes');
        }

        return redirect()->route('apbdes.index')->with('success', 'Data APBDes berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // FIX: Cari data manual juga di sini
        $apbdes = Apbdes::findOrFail($id);
        $apbdes->delete();

        return redirect()->route('apbdes.index')->with('success', 'Data APBDes berhasil dihapus.');
    }
}

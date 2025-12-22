<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index()
    {
        // Ambil data pertama (karena asumsinya cuma ada 1 data visi misi)
        $visiMisi = VisiMisi::first();

        return view('admin.pages.visimisi.index', compact('visiMisi'));
    }

    public function store(Request $request)
    {
        // $this->authorize('visi-misi.create');

        $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string|distinct',
        ]);

        // Filter misi (hapus nilai null/kosong dari array input)
        $validated['misi'] = array_filter($request->misi, fn($v) => !is_null($v) && $v !== '');
        $validated['misi'] = array_values($validated['misi']);

        $visiMisi = VisiMisi::create($validated);

        // Activity Log
        activity('visi_misi')
            ->causedBy(auth()->user())
            ->performedOn($visiMisi)
            ->withProperties([
                'new_data' => $validated,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan visi & misi baru');

        return redirect()->route('admin.visiMisi.index')->with('success', 'Visi & Misi berhasil dibuat!');
    }

    public function update(Request $request, VisiMisi $visiMisi)
    {
        // $this->authorize('visi-misi.update');

        $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string|distinct',
        ]);

        $validated['misi'] = array_filter($request->misi, fn($v) => !is_null($v) && $v !== '');
        $validated['misi'] = array_values($validated['misi']);

        // Ambil data lama untuk log
        $oldData = $visiMisi->only(['visi', 'misi']);

        $visiMisi->update($validated);

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

        if (!empty($changes)) {
            activity('visi_misi')
                ->causedBy(auth()->user())
                ->performedOn($visiMisi)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah visi & misi');
        }

        return redirect()->route('admin.visiMisi.index')->with('success', 'Visi & Misi berhasil diperbarui!');
    }
}

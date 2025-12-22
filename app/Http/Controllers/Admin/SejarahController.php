<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sejarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SejarahController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika belum ada return null
        $sejarah = Sejarah::first();
        return view('admin.pages.sejarah.index', compact('sejarah'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $data = $request->except(['foto']);

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sejarah', 'public');
        }

        $sejarah = Sejarah::create($data);

        // Activity Log
        activity('sejarah')
            ->causedBy(auth()->user())
            ->performedOn($sejarah)
            ->withProperties([
                'new_data' => $data,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan data sejarah baru');

        return redirect()->back()->with('success', 'Data Sejarah berhasil dibuat!');
    }

    public function update(Request $request, Sejarah $sejarah)
    {
        $this->validateRequest($request);

        $data = $request->except(['foto']);

        // Handle Upload Foto (hapus lama jika ada file baru)
        if ($request->hasFile('foto')) {
            if ($sejarah->foto && Storage::disk('public')->exists($sejarah->foto)) {
                Storage::disk('public')->delete($sejarah->foto);
            }
            $data['foto'] = $request->file('foto')->store('sejarah', 'public');
        }

        // Ambil data lama untuk log
        $oldData = $sejarah->only(['asal_usul', 'timeline', 'foto']);

        $sejarah->update($data);

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
            activity('sejarah')
                ->causedBy(auth()->user())
                ->performedOn($sejarah)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data sejarah');
        }

        return redirect()->back()->with('success', 'Data Sejarah berhasil diperbarui!');
    }

    private function validateRequest($request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'asal_usul' => 'required|string',
            'timeline' => 'nullable|array',
            'timeline.*.judul' => 'required_with:timeline|string',
            'timeline.*.ket' => 'required_with:timeline|string',
        ]);
    }
}

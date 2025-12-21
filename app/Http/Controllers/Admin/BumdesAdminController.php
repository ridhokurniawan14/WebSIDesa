<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bumdes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BumdesAdminController extends Controller
{
    public function index()
    {
        $bumdes = Bumdes::first();
        return view('admin.pages.bumdes.index', compact('bumdes'));
    }

    public function update(Request $request)
    {
        // Validasi text saja
        $request->validate([
            'nama' => 'required|string|max:255',
            'slogan' => 'nullable|string',
            'tentang' => 'nullable|string',
            'pengurus.*.nama' => 'required|string', // Validasi nama pengurus wajib isi
            'unit_usaha.*.nama' => 'required|string',
        ]);

        // Cek data lama atau buat baru
        $bumdes = Bumdes::first() ?? new Bumdes();

        // Ambil data lama untuk log
        $oldData = $bumdes->exists ? $bumdes->only([
            'nama',
            'slogan',
            'tentang',
            'visi',
            'misi',
            'unit_usaha',
            'pengurus',
            'kontak'
        ]) : [];

        // Bersihkan data array dari input kosong (clean up)
        $misi = array_filter($request->input('misi', []), fn($v) => !is_null($v) && $v !== '');

        // Data baru
        $newData = [
            'nama'       => $request->nama,
            'slogan'     => $request->slogan,
            'tentang'    => $request->tentang,
            'visi'       => $request->visi,
            'misi'       => array_values($misi),
            'unit_usaha' => $request->input('unit_usaha', []),
            'pengurus'   => $request->input('pengurus', []),
            'kontak'     => $request->input('kontak', []),
        ];

        // Simpan
        $bumdes->fill($newData);
        $bumdes->save();

        // Activity Log
        if ($bumdes->wasRecentlyCreated) {
            activity('bumdes')
                ->causedBy(auth()->user())
                ->performedOn($bumdes)
                ->withProperties([
                    'new_data' => $newData,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Membuat profil BUMDes');
        } else {
            $changes = [];
            foreach ($newData as $key => $value) {
                if (($oldData[$key] ?? null) != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key] ?? null,
                        'new' => $value,
                    ];
                }
            }

            if (!empty($changes)) {
                activity('bumdes')
                    ->causedBy(auth()->user())
                    ->performedOn($bumdes)
                    ->withProperties([
                        'changes' => $changes,
                        'ip' => $request->ip(),
                        'method' => $request->method(),
                    ])
                    ->log('Mengubah profil BUMDes');
            }
        }

        return redirect()->back()->with('success', 'Data BUMDes berhasil diperbarui!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aplikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class AplikasiController extends Controller
{
    public function index()
    {
        $aplikasi = Aplikasi::first();
        return view('admin.pages.aplikasi.index', compact('aplikasi'));
    }


    public function store(Request $request)
    {
        $data = $this->validateData($request);


        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logo', 'public');
        }

        Aplikasi::create($data);

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User menambah settingan baru aplikasi');

        return back()->with('success', 'Setting aplikasi berhasil disimpan');
    }

    public function update(Request $request, Aplikasi $aplikasi)
    {
        $oldData = $aplikasi->only([
            'nama_desa',
            'kabupaten',
            'nama_kantor',
            'alamat',
            'telepon',
            'email',
            'wa_cs',
            'jam_operasional',
            'facebook',
            'instagram',
            'youtube',
            'whatsapp',
            'footer',
            'map',
            'logo',
        ]);

        $data = $this->validateData($request);

        // Handle logo
        if ($request->hasFile('logo')) {
            if ($aplikasi->logo) {
                Storage::disk('public')->delete($aplikasi->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $aplikasi->update($data);

        // Ambil perubahan
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
            activity('aplikasi')
                ->causedBy(auth()->user())
                ->performedOn($aplikasi)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah setting aplikasi');
        }

        return back()->with('success', 'Setting aplikasi berhasil diperbarui');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'nama_desa' => 'required',
            'kabupaten' => 'required',
            'nama_kantor' => 'required',
            'alamat' => 'required',
            'telepon' => 'nullable',
            'email' => 'nullable|email',
            'wa_cs' => 'nullable',
            'jam_operasional' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'youtube' => 'nullable',
            'whatsapp' => 'nullable',
            'footer' => 'nullable',
            'map' => 'nullable',
            'logo' => 'nullable|image|max:2048'
        ]);
    }
}

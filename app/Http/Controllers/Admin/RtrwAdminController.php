<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Http\Request;

class RtrwAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Rw::with('rts');

        if ($q = $request->q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('dusun', 'like', "%$q%")
                    ->orWhere('nomor_rw', 'like', "%$q%")
                    ->orWhere('nama_ketua_rw', 'like', "%$q%")
                    ->orWhereHas('rts', function ($rtQuery) use ($q) {
                        $rtQuery->where('nomor_rt', 'like', "%$q%")
                            ->orWhere('nama_ketua_rt', 'like', "%$q%");
                    });
            });
        }

        if ($dusun = $request->dusun) {
            $query->where('dusun', $dusun);
        }

        $data = $query->orderBy('dusun')->orderBy('nomor_rw')->paginate(10)->withQueryString();

        $dusunOptions = ['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'];

        return view('admin.pages.rtrw.index', compact('data', 'dusunOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dusun' => 'required',
            'nomor_rw' => 'required',
            'nama_ketua_rw' => 'nullable|string',
        ]);

        $exists = Rw::where('dusun', $request->dusun)
            ->where('nomor_rw', $request->nomor_rw)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', "Gagal! RW {$request->nomor_rw} sudah ada di Dusun {$request->dusun}.");
        }

        $rw = Rw::create($validated);

        // Activity Log
        activity('rw')
            ->causedBy(auth()->user())
            ->performedOn($rw)
            ->withProperties([
                'new_data' => $validated,
                'ip' => $request->ip(),
                'method' => $request->method(),
            ])
            ->log('Menambahkan data RW');

        return redirect()->back()->with('success', 'Data RW berhasil ditambahkan');
    }

    public function update(Request $request, Rw $rtrw)
    {
        $validated = $request->validate([
            'dusun' => 'required',
            'nomor_rw' => 'required',
            'nama_ketua_rw' => 'nullable|string',
        ]);

        $exists = Rw::where('dusun', $request->dusun)
            ->where('nomor_rw', $request->nomor_rw)
            ->where('id', '!=', $rtrw->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', "Gagal Update! RW {$request->nomor_rw} sudah digunakan oleh data lain di Dusun {$request->dusun}.");
        }

        $oldData = $rtrw->only(['dusun', 'nomor_rw', 'nama_ketua_rw']);
        $rtrw->update($validated);

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
            activity('rw')
                ->causedBy(auth()->user())
                ->performedOn($rtrw)
                ->withProperties([
                    'changes' => $changes,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data RW');
        }

        return redirect()->back()->with('success', 'Data RW berhasil diperbarui');
    }

    public function destroy(Rw $rtrw)
    {
        $oldData = $rtrw->toArray();
        $rtrw->delete();

        activity('rw')
            ->causedBy(auth()->user())
            ->performedOn($rtrw)
            ->withProperties([
                'deleted_data' => $oldData,
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus data RW');

        return redirect()->back()->with('success', 'Data RW berhasil dihapus');
    }

    public function storeRt(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'rts' => 'required|array',
            'rts.*.nomor_rt' => 'required',
            'rts.*.nama_ketua_rt' => 'nullable|string',
        ]);

        $successCount = 0;
        $duplicateCount = 0;
        $newData = [];

        foreach ($request->rts as $rtData) {
            if (!empty($rtData['nomor_rt'])) {
                $exists = Rt::where('rw_id', $request->rw_id)
                    ->where('nomor_rt', $rtData['nomor_rt'])
                    ->exists();

                if (!$exists) {
                    $rt = Rt::create([
                        'rw_id' => $request->rw_id,
                        'nomor_rt' => $rtData['nomor_rt'],
                        'nama_ketua_rt' => $rtData['nama_ketua_rt'] ?? null,
                    ]);
                    $successCount++;
                    $newData[] = $rt->toArray();
                } else {
                    $duplicateCount++;
                }
            }
        }

        if ($successCount > 0) {
            activity('rt')
                ->causedBy(auth()->user())
                ->withProperties([
                    'new_data' => $newData,
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Menambahkan data RT');
        }

        if ($duplicateCount > 0) {
            $msg = "$successCount RT berhasil disimpan. $duplicateCount RT dilewati karena Nomor RT sudah ada di RW ini.";
            return redirect()->back()->with($successCount > 0 ? 'warning' : 'error', $msg);
        }

        return redirect()->back()->with('success', "$successCount Data RT berhasil ditambahkan");
    }

    public function destroyRt(Rt $rt)
    {
        $oldData = $rt->toArray();
        $rt->delete();

        activity('rt')
            ->causedBy(auth()->user())
            ->performedOn($rt)
            ->withProperties([
                'deleted_data' => $oldData,
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('Menghapus data RT');

        return redirect()->back()->with('success', 'Data RT berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Mulai query
        $query = Pesan::latest();

        // Cek jika ada pencarian (parameter 'q')
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('isi_pesan', 'like', "%{$search}%");
            });
        }

        // Paginate hasil
        $pesans = $query->paginate(10);

        // Append query string agar pagination tetap membawa parameter pencarian saat pindah halaman
        $pesans->appends(['q' => $request->q]);

        return view('admin.pages.pesan.index', compact('pesans'));
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        $deleted = 1;

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_count' => $deleted,
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus pesan: ' . $pesan->nama_lengkap);

        return back()->with('success', 'Pesan berhasil dihapus');
    }

    // HAPUS SEMUA PESAN
    public function destroyAll()
    {
        Pesan::truncate();

        // Catat aksi prune (log ini jadi termasuk 10 terbaru)
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus semua pesan');

        return back()->with('success', 'Semua pesan berhasil dihapus');
    }
}

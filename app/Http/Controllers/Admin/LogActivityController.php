<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::with('causer')
            ->when($request->q, function ($query) use ($request) {
                $query->where('description', 'like', "%{$request->q}%")
                    ->orWhere('subject_type', 'like', "%{$request->q}%");
            })
            ->when($request->method, function ($query) use ($request) {
                $query->whereJsonContains('properties->method', strtoupper($request->method));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString() // ⬅️ PENTING
            ->onEachSide(0);

        return view('admin.pages.logactivity.index', compact('logs'));
    }

    public function prune()
    {
        // Ambil ID log yang HARUS dipertahankan (10 terbaru)
        $keepIds = Activity::latest()
            ->take(10)
            ->pluck('id');

        // Hapus semua SELAIN 10 terbaru
        $deleted = Activity::whereNotIn('id', $keepIds)->delete();

        // Catat aksi prune (log ini jadi termasuk 10 terbaru)
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_count' => $deleted,
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus log aktivitas lama');

        return back()->with(
            'success',
            "Berhasil menghapus {$deleted} log lama, menyisakan 10 data terbaru"
        );
    }
}

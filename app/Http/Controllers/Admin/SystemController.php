<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Http\MaintenanceModeBypassCookie; // <--- WAJIB ADA

class SystemController extends Controller
{
    public function index()
    {
        // ... (kode index sama sprti sebelumnya)
        $isMaintenance = app()->isDownForMaintenance();
        $data = $isMaintenance && file_exists(storage_path('framework/down'))
            ? json_decode(file_get_contents(storage_path('framework/down')), true)
            : null;

        return view('admin.pages.settings.system', compact('isMaintenance', 'data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'secret' => 'nullable|alpha_dash',
        ]);

        if ($request->has('maintenance_mode')) {
            // 1. Setup & Aktifkan Down
            $secret = $request->secret ?? 'admin-access';

            Artisan::call('down', [
                '--secret' => $secret,
            ]);

            // 2. GENERATE COOKIE & PAKSA ANTRI (QUEUE)
            // Ini bedanya. Kita paksa browser simpan sekarang juga.
            $cookie = MaintenanceModeBypassCookie::create($secret);
            Cookie::queue($cookie);

            // 3. Tampilkan Preview 503
            // Kita kirim juga variable $secret buat jaga-jaga
            return response()->view('errors.503', [
                'preview' => true,
                'secret' => $secret
            ]);
        } else {
            // MATIKAN MAINTENANCE
            Artisan::call('up');

            // Hapus cookie
            Cookie::queue(Cookie::forget('laravel_maintenance'));

            return back()->with('success', 'Website sudah ONLINE kembali.');
        }
    }
}

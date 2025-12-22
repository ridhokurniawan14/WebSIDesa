<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Berita,
    Galeri,
    ProdukHukum,
    Pesan,
    User,
    Visitor
};
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use Carbon\CarbonPeriod; // Tambahan untuk range tanggal
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. CHART DATA (14 HARI TERAKHIR)
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(13); // Total 14 hari

        // Ambil data visitor group by tanggal
        $visitorsData = Visitor::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Siapkan array untuk Chart.js (Looping biar tanggal kosong tetap ada nilainya 0)
        $chartLabels = [];
        $chartValues = [];
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d M'); // Format label: 22 Des

            // Cari apakah ada visitor di tanggal ini
            $visit = $visitorsData->firstWhere('date', $dateString);
            $chartValues[] = $visit ? $visit->count : 0;
        }

        // 2. STATISTIK UTAMA
        $stats = [
            'total_berita'      => Berita::count(),
            'total_galeri'      => Galeri::count(),
            'total_pengumuman'  => ProdukHukum::count(),
            'total_pesan'       => Pesan::count(),
            'total_user'        => User::count(),

            // Statistik Pengunjung Detail
            'pengunjung_hari_ini' => Visitor::whereDate('created_at', Carbon::today())->count(),
            'pengunjung_bulan_ini' => Visitor::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)->count(),
            'pengunjung_tahun_ini' => Visitor::whereYear('created_at', Carbon::now()->year)->count(),

            'admin_online'      => Activity::whereDate('created_at', Carbon::today())
                ->whereNotNull('causer_id')
                ->distinct('causer_id')
                ->count('causer_id'),
        ];

        // 3. DATA LIST (Widget Bawah)
        $terbaru = [
            'pesan'         => Pesan::latest()->take(5)->get(),
            'berita'        => Berita::latest()->take(5)->get(),
            'user_login'    => Activity::with('causer')
                ->whereNotNull('causer_id')
                ->latest()
                ->take(5)
                ->get(),
            // Pastikan field 'views' ada di tabel berita
            'berita_populer' => Berita::orderBy('views', 'desc')->take(5)->get(),
        ];

        return view('admin.pages.dashboard.index', compact('stats', 'terbaru', 'chartLabels', 'chartValues'));
    }
}

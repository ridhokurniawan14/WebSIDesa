<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visitor;

class PruneVisitors extends Command
{
    // Ini nama perintah panggilannya nanti
    protected $signature = 'visitors:prune';

    // Penjelasannya
    protected $description = 'Menghapus data pengunjung yang lebih lama dari 3 bulan';

    public function handle()
    {
        // LOGIC PENGHAPUSAN
        // Hapus data yang dibuat sebelum 3 bulan yang lalu
        $count = Visitor::where('created_at', '<', now()->subMonths(3))->delete();

        $this->info("Berhasil menghapus {$count} data pengunjung lama.");
    }
}

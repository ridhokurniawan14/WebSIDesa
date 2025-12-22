<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor; // Pastikan Model Visitor diimport
use Illuminate\Support\Facades\Auth;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jalankan request dulu (Next)
        $response = $next($request);

        // Setelah halaman dimuat, baru kita catat (biar gak lemot di awal)
        // Kita filter: Jangan catat kalau method HEAD (biasanya bot cek link doang)
        if ($request->method() !== 'HEAD') {
            try {
                Visitor::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url'        => $request->fullUrl(),
                    'method'     => $request->method(),
                    'referer'    => $request->header('referer'),
                    'user_id'    => Auth::id(), // Akan null jika tamu biasa
                ]);
            } catch (\Exception $e) {
                // Diam saja kalau error (biar user gak sadar kalau tracking error)
                // Log::error($e->getMessage()); 
            }
        }

        return $response;
    }
}

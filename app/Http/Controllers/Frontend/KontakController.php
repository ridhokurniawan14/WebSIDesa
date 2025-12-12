<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('frontend.pages.kontak.index');
    }

    public function kirim(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required',
        ]);

        // Karena masih statis, kita belum simpan ke DB.
        // Anggap ini berhasil terkirim.
        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}

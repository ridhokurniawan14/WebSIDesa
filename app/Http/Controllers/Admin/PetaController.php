<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peta;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
    {
        // Ambil data pertama. Jika tabel kosong, hasilnya null (aman).
        $peta = Peta::first();
        return view('admin.pages.petadesa.index', compact('peta'));
    }

    public function store(Request $request)
    {
        // 1. Bersihkan Data (Hapus titik ribuan & Decode JSON Polygon)
        $this->cleanRequest($request);

        // 2. Validasi
        $data = $this->validateRequest($request);

        // 3. LOGIC PINTAR (Cek Existing Data)
        // Kita cek apakah sudah ada data peta?
        $peta = Peta::first();

        if ($peta) {
            // JIKA ADA -> UPDATE
            $peta->update($data);
            $action = 'diperbarui';

            // Log Activity (Update)
            activity('peta')
                ->causedBy(auth()->user())
                ->performedOn($peta)
                ->withProperties(['ip' => $request->ip()])
                ->log('Memperbarui peta desa');
        } else {
            // JIKA KOSONG -> CREATE BARU
            $peta = Peta::create($data);
            $action = 'dibuat';

            // Log Activity (Create)
            activity('peta')
                ->causedBy(auth()->user())
                ->performedOn($peta)
                ->withProperties(['ip' => $request->ip()])
                ->log('Membuat peta desa baru');
        }

        return redirect()->route('admin.peta.index')->with('success', "Data Peta berhasil $action!");
    }

    public function update(Request $request, Peta $peta)
    {
        // Redirect ke store saja biar logicnya terpusat di satu tempat (Single Row Logic)
        return $this->store($request);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'batas_utara'      => 'nullable|string|max:255',
            'batas_timur'      => 'nullable|string|max:255',
            'batas_selatan'    => 'nullable|string|max:255',
            'batas_barat'      => 'nullable|string|max:255',
            'luas_wilayah'     => 'required|numeric|min:0',
            'koordinat_kantor' => 'nullable|string',
            'polygon_wilayah'  => 'nullable|array', // Wajib array (hasil decode cleanRequest)
            'zoom_level'       => 'nullable|integer'
        ]);
    }

    private function cleanRequest(Request $request)
    {
        $mergeData = [];

        // Fix Luas Wilayah (Hapus titik ribuan: 15.000 -> 15000)
        if ($request->has('luas_wilayah')) {
            $cleanLuas = str_replace('.', '', $request->luas_wilayah);
            $cleanLuas = str_replace(',', '.', $cleanLuas);
            $mergeData['luas_wilayah'] = $cleanLuas;
        }

        // Fix Polygon (String JSON -> Array PHP)
        if ($request->has('polygon_wilayah')) {
            $rawPoly = $request->polygon_wilayah;

            // Jika kosong/null/array kosong string
            if (empty($rawPoly) || $rawPoly === '[]' || $rawPoly === 'null') {
                $mergeData['polygon_wilayah'] = null;
            }
            // Jika string, coba decode
            elseif (is_string($rawPoly)) {
                $decoded = json_decode($rawPoly, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $mergeData['polygon_wilayah'] = $decoded;
                } else {
                    $mergeData['polygon_wilayah'] = null;
                }
            }
        }

        if (!empty($mergeData)) {
            $request->merge($mergeData);
        }
    }
}

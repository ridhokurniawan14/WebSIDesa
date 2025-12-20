<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pembangunan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.pembangunan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembangunan $pembangunan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembangunan $pembangunan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembangunan $pembangunan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembangunan $pembangunan)
    {
        //
    }
}

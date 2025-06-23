<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosenpa;

class PengaduanForDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.pengaduan.dosen', [
            'title' => 'Pengaduan', 
            'active' => 'pengaduan',
            'pengaduan' => Pengaduan::all(),
            'mahasiswa' => Mahasiswa::all(),
            // 'dosen_pa' => Dosenpa::all()
        ]);
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
        // dd($request->pengaduan_id);
        Pengaduan::where('id', $request->pengaduan_id)->update(['status' => 'tolak']);
        return redirect('/dashboard/pengaduan-dosen')->with('success', 'Pengaduan berhasil ditolak');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        //

        return view('dashboard.pengaduan.edit', [
            'title' => 'Edit Pengaduan',
            'active' => 'pengaduan',
            'pengaduan' => Pengaduan::find($pengaduan->id),
            'mahasiswa' => Mahasiswa::all(),
            'dosen_pa' => Dosenpa::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        //
    }
}

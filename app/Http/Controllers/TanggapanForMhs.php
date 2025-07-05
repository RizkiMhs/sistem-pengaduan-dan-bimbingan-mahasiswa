<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanForMhs extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Dapatkan ID mahasiswa yang sedang login.
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // 2. Dapatkan semua ID pengaduan yang dimiliki oleh mahasiswa tersebut.
        $pengaduanIds = Auth::user()->mahasiswa->pengaduan->pluck('id');

        // 3. Ambil hanya tanggapan yang pengaduan_id-nya ada di dalam daftar ID di atas.
        $tanggapan = Tanggapan::whereIn('pengaduan_id', $pengaduanIds)
                                ->with('pengaduan', 'user') // Eager load relasi untuk efisiensi
                                ->latest()
                                ->get();

        return view('dashboard.tanggapan.mhs.index', [
            'title' => 'Tanggapan Diterima',
            'active' => 'tanggapan',
            'tanggapan' => $tanggapan
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }
}

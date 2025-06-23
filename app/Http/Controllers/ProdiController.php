<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Models\Fakultas;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.prodi.index', [
        'title' => 'Program Studi',
        'active' => 'prodi',
        // 'with('fakultas')' membuat query lebih efisien (Eager Loading)
        'prodi' => Prodi::with('fakultas')->get(), 
        // Ambil SEMUA data dari tabel fakultas
        'fakultas' => Fakultas::all(), 
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
        $valid = $request->validate([
            'nama_prodi' => 'required',
            'fakultas_id' => 'required',
            'jenjang' => 'required',
        ]);
        Prodi::create($valid);
        return redirect('/dashboard/prodi')->with('success', 'Program Studi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        //
        $valid = $request->validate([
            'nama_prodi' => 'required',
            'fakultas_id' => 'required',
            'jenjang' => 'required',
        ]);
        Prodi::where('id', $prodi->id)->update($valid);
        return redirect('/dashboard/prodi')->with('success', 'Program Studi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        //
        Prodi::destroy($prodi->id);
        return redirect('/dashboard/prodi')->with('success', 'Program Studi berhasil dihapus');
    }
}

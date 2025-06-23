<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.fakultas.index', [
            'title' => 'Fakultas',
            'active' => 'fakultas',
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
        $valid = $request->validate([
            'nama_fakultas' => 'required',
        ]);
        Fakultas::create($valid);
        return redirect('/dashboard/fakultas')->with('success', 'Fakultas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fakultas $fakultas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fakultas $fakultas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fakultas $fakultas)
    {
        $valid = $request->validate([
            'nama_fakultas' => 'required',
        ]);

        // PERBAIKAN: Gunakan instance model ($fakultas) yang sudah didapat
        // dari route untuk melakukan update. Ini lebih efisien.
        $fakultas->update($valid);

        return redirect('/dashboard/fakultas')->with('success', 'Fakultas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakultas $fakultas)
    {
        // PERBAIKAN: Gunakan metode delete() pada instance model ($fakultas)
        // yang sudah didapat dari route.
        $fakultas->delete();

        return redirect('/dashboard/fakultas')->with('success', 'Fakultas berhasil dihapus');
    }
}

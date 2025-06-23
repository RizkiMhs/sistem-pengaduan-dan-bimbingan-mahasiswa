<?php

namespace App\Http\Controllers;

use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.kelas.index', [
            'title' => 'Tingkat',
            'active' => 'kelas',
            'tingkat' => Tingkat::all()
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
            'nama_kelas' => 'required',
            'angkatan' => 'required',
        ]);

        Tingkat::create($valid);
        return redirect('/dashboard/kelas')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tingkat $tingkat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tingkat $tingkat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tingkat $tingkat)
    {
        //
        $valid = $request->validate([
            'nama_kelas' => 'required',
            'angkatan' => 'required',
        ]);

        Tingkat::where('id', $tingkat->id)->update($valid);
        return redirect('/dashboard/kelas')->with('success', 'Kelas berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tingkat $tingkat)
    {
        //
        Tingkat::destroy($tingkat->id);
        return redirect('/dashboard/kelas')->with('success', 'Kelas berhasil dihapus');
    }
}

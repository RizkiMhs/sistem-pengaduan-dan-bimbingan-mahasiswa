<?php

namespace App\Http\Controllers;

use App\Models\KategoriBimbingan;
use Illuminate\Http\Request;

class KategoriBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.kategori_bimbingan.index', [
            'kategoriBimbingans' => KategoriBimbingan::all(),
            'active' => 'kategori-bimbingan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * (Not used as we use a modal for the form)
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
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_bimbingans',
            'deskripsi' => 'nullable|string'
        ]);

        KategoriBimbingan::create($validatedData);

        return redirect('/dashboard/kategori-bimbingan')->with('success', 'Kategori bimbingan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * (Not used)
     */
    public function show(KategoriBimbingan $kategoriBimbingan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * (Not used as we use a modal for the form)
     */
    public function edit(KategoriBimbingan $kategoriBimbingan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriBimbingan $kategoriBimbingan)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_bimbingans,nama_kategori,' . $kategoriBimbingan->id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategoriBimbingan->update($validatedData);

        return redirect('/dashboard/kategori-bimbingan')->with('success', 'Kategori bimbingan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBimbingan $kategoriBimbingan)
    {
        try {
            $kategoriBimbingan->delete();
            return redirect('/dashboard/kategori-bimbingan')->with('success', 'Kategori bimbingan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Menangkap error jika kategori ini sudah digunakan di tabel lain (foreign key constraint)
            return back()->with('error', 'Gagal menghapus! Kategori ini sudah digunakan oleh data lain.');
        }
    }
}

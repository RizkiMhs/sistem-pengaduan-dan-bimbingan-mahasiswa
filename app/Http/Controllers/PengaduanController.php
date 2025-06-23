<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.pengaduan.index', [
            'title' => 'Pengaduan', 
            'active' => 'pengaduan',
            'pengaduan' => Pengaduan::all(),
            'mahasiswa' => Mahasiswa::all()
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
            'isi_pengaduan' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $valid['mahasiswa_id'] = auth()->user()->mahasiswa->id;
        $valid['status'] = 'proses';

        $valid['foto'] = $request->file('foto')->store('foto-pengaduan');

        Pengaduan::create($valid);

        return redirect('/dashboard/pengaduan')->with('success', 'Pengaduan berhasil dikirim');



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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        //
        $valid = $request->validate([
            'isi_pengaduan' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $valid['status'] = 'proses';

        if ($request->file('foto')) {
            if ($pengaduan->foto != 'foto-pengaduan/default.png') {
                Storage::delete($pengaduan->foto);
            }
            $valid['foto'] = $request->file('foto')->store('foto-pengaduan');
        }

        Pengaduan::where('id', $pengaduan->id)->update($valid);
        return redirect('/dashboard/pengaduan')->with('success', 'Pengaduan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        //
        if ($pengaduan->foto != 'foto-pengaduan/default.png') {
            Storage::delete($pengaduan->foto);
        }        

        Pengaduan::destroy($pengaduan->id);
        return redirect('/dashboard/pengaduan')->with('success', 'Pengaduan berhasil dihapus');
    }
}

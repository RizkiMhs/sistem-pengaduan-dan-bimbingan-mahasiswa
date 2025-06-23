<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

             

        return view('dashboard.tanggapan.index', [
            'title' => 'Tanggapan',
            'active' => 'tanggapan',
            'tanggapan' => Tanggapan::all(),
            'pengaduan' => Pengaduan::all()
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
            'isi_tanggapan' => 'required',
            'pengaduan_id' => 'required'

        ]);

        // $valid['pengaduan_id'] = $request->pengaduan_id;
        // $valid['pengaduan_id']=1;

        $valid['dosenpa_id'] = auth()->user()->dosenpa->id;

        Tanggapan::create($valid);
        Pengaduan::where('id', $request->pengaduan_id)->update(['status' => 'selesai']);
        return redirect('/dashboard/pengaduan-dosen')->with('success', 'Tanggapan berhasil dikirim');

        
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }
}

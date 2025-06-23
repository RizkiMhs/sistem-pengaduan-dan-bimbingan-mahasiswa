<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TanggapanForAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $tanggapan = Tanggapan::all();
        // if (request()->cari) {
        //     $tanggapan = Tanggapan::whereHas('dosenpa', function($query){
        //         $query->where('nama', 'like', '%' . request()->cari . '%');
        //     })->orwhereHas('pengaduan', function($query){
        //         $query->whereHas('mahasiswa', function($query){
        //             $query->where('nama', 'like', '%' . request()->cari . '%');
        //         });
        //     })->get();
            
        // }
        // // filter berdasarkan tanggal start dan end
        // if (request()->start && request()->end) {
        //     $tanggapan = Tanggapan::whereBetween('created_at', [Carbon::parse(request()->start), Carbon::parse(request()->end)])->get();
        // }


        return view('dashboard.tanggapan.admin.index',[
            'title' => 'Tanggapan',
            'active' => 'tanggapan',
            'tanggapan' => Tanggapan::filter(request(['cari', 'start', 'end']))->paginate(5),
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

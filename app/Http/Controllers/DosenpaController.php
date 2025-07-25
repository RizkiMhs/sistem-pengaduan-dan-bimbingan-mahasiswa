<?php

namespace App\Http\Controllers;

use App\Models\Dosenpa;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenpaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.dosenpa.index', [
            'dosenpa' => Dosenpa::all(),    
            'active' => 'dosen-pa'
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
        // return $request->file('foto')->store('foto-dosenpa'); 

        $valisasiData = $request->validate([
            'nama' => 'required|max:255',
            'nidn' => 'required|max:16',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'foto'=> 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::create([
            'name' => $valisasiData['nama'],
            'email' => $valisasiData['email'],
            'password' => bcrypt($valisasiData['password']),
            'role' => 'dosenpa',
        ]);
        // $user_id = User::latest('id')->first()->id + 1;
        $valisasiData['password'] = bcrypt($valisasiData['password']);
        // $valisasiData['foto'] = $request->file('foto')->store('foto-dosenpa');
        if ($request->file('foto')) {
            $valisasiData['foto'] = $request->file('foto')->store('foto-dosenpa');
        } else {
            $valisasiData['foto'] = 'foto-dosenpa/default.png';
        }

        $valisasiData['user_id'] = $user['id'];

        
        
        $dosenpa = Dosenpa::create($valisasiData);

    
        return redirect('/dashboard/dosen-pa')->with('success', 'Data Dosenpa berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Dosenpa $dosenpa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosenpa $dosenpa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosenpa $dosenpa)
    {
        //
        $valisasiData = $request->validate([
            'nama' => 'required|max:255',
            'nidn' => 'required|max:16',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'foto'=> 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::where('id', $dosenpa->user_id)->update([
            'name' => $valisasiData['nama'],
            'email' => $valisasiData['email'],
            'password' => bcrypt($valisasiData['password']),
            'role' => 'dosenpa',
        ]);

        $valisasiData['password'] = bcrypt($valisasiData['password']);
        if ($request->file('foto')) {
            if ($dosenpa->foto != 'foto-dosenpa/default.png') {
                unlink('storage/' . $dosenpa->foto);
            }
            $valisasiData['foto'] = $request->file('foto')->store('foto-dosenpa');
        } else {
            $valisasiData['foto'] = $dosenpa->foto;
        }

        Dosenpa::where('id', $dosenpa->id)
            ->update($valisasiData);

        return redirect('/dashboard/dosen-pa')->with('success', 'Data Dosenpa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosenpa $dosenpa)
    {
        //

        if ($dosenpa->foto != 'foto-dosenpa/default.png') {
            unlink('storage/' . $dosenpa->foto);
        }

        Dosenpa::destroy($dosenpa->id);

        // Rating::where('dosen_id', $dosenpa->id)->delete();
        User::destroy($dosenpa->user_id);

        return redirect('/dashboard/dosen-pa')->with('success', 'Data Dosenpa berhasil dihapus');
    }
}

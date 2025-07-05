<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Dosenpa;
use App\Models\Prodi;
use App\Models\Tingkat;


use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (auth()->user()->role === 'mahasiswa' ){
            return redirect('/dashboard');
        }
        return view('dashboard.mhs.index', [
            'title' => 'Mahasiswa',
            'active' => 'mahasiswa',
            // 'mahasiswa' =>  Mahasiswa::where('dosenpa_id', auth()->user()->dosenpa->id)->get(),
            'mahasiswa' =>  Mahasiswa::all(),
            'dosenpa' => Dosenpa::all(),
            'prodi' => Prodi::all()

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
            'nama' => 'required|max:255',
            'nim' => 'required|max:16',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
            // 'dosenpa_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'id_tingkat' => 'required',
        ]);

        // $dosenpa = Dosenpa::where('id', $valid['dosenpa_id'])->first();
        $valid['dosenpa_id'] = auth()->user()->dosenpa->id;

        $user = User::create([
            'name' => $valid['nama'],
            'email' => $valid['email'],
            'password' => bcrypt($valid['password']),
            'role' => 'mahasiswa',
        ]);

        $valid['user_id'] = $user->id;
        $valid['password'] = bcrypt($valid['password']);
        if ($request->file('foto')){
            $valid['foto'] = $request->file('foto')->store('foto-mahasiswa');
        } else {
            $valid['foto'] = 'foto-mahasiswa/default.png';
        }
        // $valid['foto'] = $request->file('foto')->store('foto-mahasiswa');
        


        Mahasiswa::create($valid);

        return redirect('/dashboard/mahasiswa')->with('success', 'Mahasiswa has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
        $valid = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:16',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'dosenpa_id' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'id_tingkat' => 'required',
        ]);

        $user = User::where('id', $mahasiswa->user_id)->update([
            'name' => $valid['nama'],
            'email' => $valid['email'],
            'password' => bcrypt($valid['password']),
            'role' => 'mahasiswa',
        ]);

        $valid['password'] = bcrypt($valid['password']);
        if ($request->file('foto')) {
            if ($mahasiswa->foto != 'foto-mahasiswa/default.png') {
                unlink('storage/' . $mahasiswa->foto);
            }
            $valid['foto'] = $request->file('foto')->store('foto-mahasiswa');
        } else {
            $valid['foto'] = $mahasiswa->foto;
        }

        Mahasiswa::where('id', $mahasiswa->id)
            ->update($valid);

        return redirect('/dashboard/mahasiswa')->with('success', 'Data Mahasiswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //

        if ($mahasiswa->foto != 'foto-mahasiswa/default.png') {
            unlink('storage/' . $mahasiswa->foto);
        }

        User::destroy($mahasiswa->user_id);
        Mahasiswa::destroy($mahasiswa->id);

        return redirect('/dashboard/mahasiswa')->with('success', 'Mahasiswa has been deleted');
    }
}

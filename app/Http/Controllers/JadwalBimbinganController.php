<?php

namespace App\Http\Controllers;

use App\Models\JadwalBimbingan;
use App\Models\KategoriBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan jadwal yang dibuat oleh Dosen PA yang sedang login.
     */
    public function index()
    {
        // Ambil ID Dosen PA yang sedang login
        $dosenpaId = Auth::user()->dosenpa->id;

        return view('dashboard.jadwal_bimbingan.index', [
            // Eager load relasi untuk efisiensi query
            'jadwalBimbingans' => JadwalBimbingan::where('dosenpa_id', $dosenpaId)
                                                ->with('kategoriBimbingan')
                                                ->latest()->get(),
            'kategoriBimbingans' => KategoriBimbingan::all(),
            'active' => 'jadwal-bimbingan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * (Tidak digunakan karena memakai modal)
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
            'kategori_bimbingan_id' => 'required|exists:kategori_bimbingans,id',
            'topik_umum' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'kuota_per_hari' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Ditutup',
        ]);

        // Tambahkan dosenpa_id dari user yang sedang login
        $validatedData['dosenpa_id'] = Auth::user()->dosenpa->id;
        
        // Asumsi waktu selesai adalah 1 jam setelah waktu mulai, bisa disesuaikan.
        $validatedData['waktu_selesai'] = (new \DateTime($validatedData['waktu_mulai']))->modify('+1 hour');

        JadwalBimbingan::create($validatedData);

        return redirect('/dashboard/jadwal-bimbingan')->with('success', 'Jadwal bimbingan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalBimbingan $jadwalBimbingan)
    {
        // Bisa digunakan nanti untuk melihat detail pendaftar di jadwal ini
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalBimbingan $jadwalBimbingan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalBimbingan $jadwalBimbingan)
    {
        // Pastikan dosen yang mengedit adalah pemilik jadwal
        if ($jadwalBimbingan->dosenpa_id !== Auth::user()->dosenpa->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'kategori_bimbingan_id' => 'required|exists:kategori_bimbingans,id',
            'topik_umum' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'kuota_per_hari' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Penuh,Ditutup', // Tambahkan status 'Penuh'
        ]);
        
        $validatedData['waktu_selesai'] = (new \DateTime($validatedData['waktu_mulai']))->modify('+1 hour');

        $jadwalBimbingan->update($validatedData);

        return redirect('/dashboard/jadwal-bimbingan')->with('success', 'Jadwal bimbingan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalBimbingan $jadwalBimbingan)
    {
        // Pastikan dosen yang menghapus adalah pemilik jadwal
        if ($jadwalBimbingan->dosenpa_id !== Auth::user()->dosenpa->id) {
            abort(403);
        }
        
        try {
            $jadwalBimbingan->delete();
            return redirect('/dashboard/jadwal-bimbingan')->with('success', 'Jadwal bimbingan berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus jadwal. Mungkin sudah ada mahasiswa yang mendaftar.');
        }
    }
}

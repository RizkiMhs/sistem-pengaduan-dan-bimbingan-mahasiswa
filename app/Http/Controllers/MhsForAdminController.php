<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Dosenpa;
use App\Models\Prodi; // Mengganti Tingkat dengan Prodi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Untuk transaksi

class MhsForAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.mhs.foradmin', [
            'title' => 'Mahasiswa',
            'active' => 'mahasiswa',
            // Eager load relasi untuk menghindari N+1 query problem
            'mahasiswa' => Mahasiswa::all(), 
            'dosenpa' => Dosenpa::all(),
            // Mengganti Tingkat::all() dengan Prodi::all()
            'prodi' => Prodi::all()
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
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:mahasiswas',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'dosenpa_id' => 'required|exists:dosenpas,id',
            'prodi_id' => 'required|exists:prodis,id',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User terlebih dahulu
            $user = User::create([
                'name' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'mahasiswa',
            ]);

            // 2. Siapkan data untuk Mahasiswa
            $mahasiswaData = $validatedData;
            $mahasiswaData['user_id'] = $user->id;

            // 3. Handle upload foto
            if ($request->file('foto')) {
                $mahasiswaData['foto'] = $request->file('foto')->store('foto-mahasiswa', 'public');
            }

            // 4. Buat data Mahasiswa
            Mahasiswa::create($mahasiswaData);

            DB::commit(); // Simpan semua perubahan jika berhasil

            return redirect('/dashboard/mahasiswa-admin')->with('success', 'Data Mahasiswa berhasil ditambahkan!');
        
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            return back()->with('error', 'Gagal menambahkan data! Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * (Tidak digunakan)
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * (Tidak digunakan)
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
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:mahasiswas,nim,' . $mahasiswa->id,
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'dosenpa_id' => 'required|exists:dosenpas,id',
            'prodi_id' => 'required|exists:prodis,id',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data user terkait
            $mahasiswa->user()->update([
                'name' => $validatedData['nama'],
                'email' => $validatedData['email'],
            ]);

            // 2. Handle update foto
            if ($request->file('foto')) {
                // Hapus foto lama jika ada
                if ($mahasiswa->foto) {
                    Storage::disk('public')->delete($mahasiswa->foto);
                }
                $validatedData['foto'] = $request->file('foto')->store('foto-mahasiswa', 'public');
            }

            // 3. Update data mahasiswa
            $mahasiswa->update($validatedData);

            DB::commit();

            return redirect('/dashboard/mahasiswa-admin')->with('success', 'Data Mahasiswa berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data! Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            // Hapus foto dari storage jika ada
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            // Hapus user terkait, yang akan cascade menghapus mahasiswa
            // (jika onDelete('cascade') di-set pada user_id di migration)
            // Atau hapus mahasiswa yang akan cascade hapus user.
            // Paling aman adalah menghapus user.
            User::destroy($mahasiswa->user_id);
            // Mahasiswa::destroy($mahasiswa->id); // Baris ini tidak perlu jika user sudah dihapus dengan cascade

            return redirect('/dashboard/mahasiswa-admin')->with('success', 'Data Mahasiswa berhasil dihapus!');
        
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data! Error: ' . $e->getMessage());
        }
    }
}

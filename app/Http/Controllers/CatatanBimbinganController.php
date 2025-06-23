<?php

namespace App\Http\Controllers;

use App\Models\CatatanBimbingan;
use App\Models\PendaftaranBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatatanBimbinganController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran_bimbingans,id',
            'catatan_dosen' => 'nullable|string',
            'dokumen_revisi_dosen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'catatan_mahasiswa' => 'nullable|string',
        ]);

        $pendaftaran = PendaftaranBimbingan::find($validatedData['pendaftaran_id']);
        $user = Auth::user();

        // Autorisasi: Pastikan yang mengisi adalah Dosen atau Mahasiswa yang bersangkutan
        $isOwner = $user->role == 'mahasiswa' && $pendaftaran->mahasiswa_id === $user->mahasiswa->id;
        $isLecturer = $user->role == 'dosenpa' && $pendaftaran->jadwalBimbingan->dosenpa_id === $user->dosenpa->id;

        if (!$isOwner && !$isLecturer) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengisi catatan ini.');
        }

        // Cek apakah catatan sudah ada atau belum
        $catatan = CatatanBimbingan::firstOrNew(['pendaftaran_id' => $validatedData['pendaftaran_id']]);

        // Isi data berdasarkan peran
        if ($isLecturer) {
            $catatan->catatan_dosen = $validatedData['catatan_dosen'];
            if ($request->file('dokumen_revisi_dosen')) {
                // Hapus file lama jika ada
                if ($catatan->dokumen_revisi_dosen) {
                    Storage::disk('public')->delete($catatan->dokumen_revisi_dosen);
                }
                $catatan->dokumen_revisi_dosen = $request->file('dokumen_revisi_dosen')->store('dokumen-revisi', 'public');
            }
        }

        if ($isOwner) {
            $catatan->catatan_mahasiswa = $validatedData['catatan_mahasiswa'];
        }

        $catatan->save();
        
        // Tandai bimbingan sebagai 'Selesai' jika dosen yang mengisi catatan
        if($isLecturer) {
            $pendaftaran->update(['status_pengajuan' => 'Selesai']);
        }

        return back()->with('success', 'Catatan bimbingan berhasil disimpan!');
    }


    /**
     * Update the specified resource in storage.
     * (Mirip dengan store, bisa digunakan untuk form edit khusus)
     */
    public function update(Request $request, CatatanBimbingan $catatanBimbingan)
    {
        // Logika di sini sangat mirip dengan store, bisa disesuaikan jika
        // ada alur "edit" yang berbeda dengan "tambah" catatan.
        // Untuk saat ini, kita bisa panggil method store.
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatatanBimbingan $catatanBimbingan)
    {
        try {
            // Hapus file dari storage jika ada
            if ($catatanBimbingan->dokumen_revisi_dosen) {
                Storage::disk('public')->delete($catatanBimbingan->dokumen_revisi_dosen);
            }

            $catatanBimbingan->delete();
            return back()->with('success', 'Catatan bimbingan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus catatan.');
        }
    }

    // Method berikut tidak digunakan dalam alur ini
    public function index() { /* ... */ }
    public function create() { /* ... */ }
    public function show(CatatanBimbingan $catatanBimbingan) { /* ... */ }
    public function edit(CatatanBimbingan $catatanBimbingan) { /* ... */ }
}

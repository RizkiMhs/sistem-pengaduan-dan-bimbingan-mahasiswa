<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranBimbingan;
use App\Models\JadwalBimbingan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PendaftaranBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'dosenpa') {
            $dosenpaId = Auth::user()->dosenpa->id;
            $pendaftarans = PendaftaranBimbingan::whereHas('jadwalBimbingan', function ($query) use ($dosenpaId) {
                $query->where('dosenpa_id', $dosenpaId);
            })->with(['mahasiswa', 'jadwalBimbingan'])->latest()->get();

            // Nama view untuk dosen perlu disesuaikan jika berbeda
            return view('dashboard.pendaftaran_bimbingan.dosen_index', [
                'pendaftarans' => $pendaftarans,
                'active' => 'pendaftaran-bimbingan'
            ]);
        }

        if (Auth::user()->role == 'mahasiswa') {
            $mahasiswaId = Auth::user()->mahasiswa->id;
            
            // Mengambil riwayat pendaftaran mahasiswa
            $pendaftarans = PendaftaranBimbingan::where('mahasiswa_id', $mahasiswaId)
                ->with('jadwalBimbingan.dosenpa')
                ->latest()->get();
            
            // Ambil juga data jadwal yang tersedia
            $jadwalTersedia = JadwalBimbingan::where('status', 'Tersedia')
                                ->with(['dosenpa', 'kategoriBimbingan', 'pendaftaranBimbingan'])
                                ->whereDoesntHave('pendaftaranBimbingan', function ($query) use ($mahasiswaId) {
                                    // Sembunyikan jadwal jika mahasiswa sudah mendaftar di sana
                                    $query->where('mahasiswa_id', $mahasiswaId);
                                })
                                ->latest()->get();

            // Nama view di sini sudah benar sesuai dengan yang ada di Canvas
            return view('dashboard.pendaftaran_bimbingan.mahasiswa_index', [
                'pendaftarans' => $pendaftarans,
                'jadwalTersedia' => $jadwalTersedia, // <-- Kirim variabel ini ke view
                'active' => 'pendaftaran-bimbingan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     * (Aksi ini ditambahkan untuk melihat detail pengajuan)
     */
    public function show(PendaftaranBimbingan $pendaftaranBimbingan)
    {
        $user = Auth::user();

        // Autorisasi: Pastikan yang mengakses adalah mahasiswa ybs atau dosenpa terkait.
        $isOwner = $user->role == 'mahasiswa' && $pendaftaranBimbingan->mahasiswa_id === $user->mahasiswa->id;
        $isLecturer = $user->role == 'dosenpa' && $pendaftaranBimbingan->jadwalBimbingan->dosenpa_id === $user->dosenpa->id;

        if (!$isOwner && !$isLecturer) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        // Eager load semua relasi yang dibutuhkan untuk halaman detail
        $pendaftaranBimbingan->load(['mahasiswa.user', 'jadwalBimbingan.dosenpa', 'jadwalBimbingan.kategoriBimbingan', 'catatanBimbingan']);

        return view('dashboard.pendaftaran_bimbingan.show', [
            'pendaftaran' => $pendaftaranBimbingan,
            'active' => 'pendaftaran-bimbingan'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jadwal_bimbingan_id' => 'required|exists:jadwal_bimbingans,id',
            'topik_mahasiswa' => 'required|string|max:255',
            'deskripsi_mahasiswa' => 'required|string',
            'dokumen_mahasiswa' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048'
        ]);

        $mahasiswaId = Auth::user()->mahasiswa->id;
        $jadwal = JadwalBimbingan::find($validatedData['jadwal_bimbingan_id']);

        if ($jadwal->status !== 'Tersedia') {
            return back()->with('error', 'Jadwal ini sudah tidak tersedia atau penuh.');
        }

        $isAlreadyRegistered = PendaftaranBimbingan::where('mahasiswa_id', $mahasiswaId)
            ->where('jadwal_bimbingan_id', $jadwal->id)
            ->exists();

        if ($isAlreadyRegistered) {
            return back()->with('error', 'Anda sudah mendaftar pada jadwal ini.');
        }
        
        DB::beginTransaction();
        try {
            if ($request->file('dokumen_mahasiswa')) {
                $validatedData['dokumen_mahasiswa'] = $request->file('dokumen_mahasiswa')->store('dokumen-bimbingan', 'public');
            }

            $validatedData['mahasiswa_id'] = $mahasiswaId;
            $validatedData['status_pengajuan'] = 'Diajukan';

            PendaftaranBimbingan::create($validatedData);

            $jumlahDiterima = PendaftaranBimbingan::where('jadwal_bimbingan_id', $jadwal->id)
                                ->where('status_pengajuan', 'Diterima')->count();
            
            if (($jumlahDiterima + 1) >= $jadwal->kuota_per_hari) {
                $jadwal->update(['status' => 'Penuh']);
            }

            DB::commit();

            return redirect('/dashboard/pendaftaran-bimbingan')->with('success', 'Pengajuan bimbingan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengirim pengajuan. Error: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendaftaranBimbingan $pendaftaranBimbingan)
    {
         if ($pendaftaranBimbingan->jadwalBimbingan->dosenpa_id !== Auth::user()->dosenpa->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'status_pengajuan' => 'required|in:Diterima,Ditolak,Selesai'
        ]);

        // PERBAIKAN: Gunakan transaksi database untuk memastikan semua operasi berhasil
        DB::transaction(function () use ($pendaftaranBimbingan, $validatedData) {
            // 1. Update status pengajuan mahasiswa
            $pendaftaranBimbingan->update($validatedData);

            // 2. Ambil jadwal terkait
            $jadwal = $pendaftaranBimbingan->jadwalBimbingan;

            // 3. Hitung ulang jumlah pendaftar yang sudah diterima
            $jumlahDiterima = PendaftaranBimbingan::where('jadwal_bimbingan_id', $jadwal->id)
                                ->where('status_pengajuan', 'Diterima')
                                ->count();

            // 4. Update status jadwal berdasarkan kuota
            if ($jumlahDiterima >= $jadwal->kuota_per_hari) {
                $jadwal->update(['status' => 'Penuh']);
            } else {
                // Jika ada yang ditolak dan kuota jadi kosong, ubah kembali jadi tersedia
                $jadwal->update(['status' => 'Tersedia']);
            }
        });

        return back()->with('success', 'Status pengajuan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendaftaranBimbingan $pendaftaranBimbingan)
    {
        if ($pendaftaranBimbingan->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403);
        }

        if($pendaftaranBimbingan->status_pengajuan !== 'Diajukan') {
            return back()->with('error', 'Gagal membatalkan. Pengajuan ini sudah diproses oleh dosen.');
        }

        try {
            if ($pendaftaranBimbingan->dokumen_mahasiswa) {
                Storage::disk('public')->delete($pendaftaranBimbingan->dokumen_mahasiswa);
            }

            $pendaftaranBimbingan->delete();
            return back()->with('success', 'Pengajuan bimbingan berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan pengajuan.');
        }
    }
}

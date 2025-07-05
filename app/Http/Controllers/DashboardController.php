<?php

namespace App\Http\Controllers;

use App\Models\Dosenpa;
use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\PendaftaranBimbingan;
use App\Models\Tanggapan;
use App\Models\JadwalBimbingan; // Ditambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     * Menampilkan halaman dashboard dengan data yang sesuai dengan peran pengguna.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
        ];

        if ($user->role == 'kaprodi') {
            $data += [
                'totalDosenpa' => Dosenpa::count(),
                'totalMahasiswa' => Mahasiswa::count(),
                'totalPengaduan' => Pengaduan::count(),
                'totalPengaduanProses' => Pengaduan::where('status', 'proses')->count(),
                'totalTanggapan' => Tanggapan::count(),
                // Statistik Bimbingan untuk Admin
                'totalJadwalBimbingan' => JadwalBimbingan::count(),
                'totalPendaftaranBimbingan' => PendaftaranBimbingan::count(),
            ];
        }

        if ($user->role == 'dosenpa') {
            $dosenpaId = $user->dosenpa->id;
            $mahasiswaIds = Mahasiswa::where('dosenpa_id', $dosenpaId)->pluck('id');
            
            $data += [
                'totalMahasiswa' => count($mahasiswaIds),
                'totalPengaduan' => Pengaduan::whereIn('mahasiswa_id', $mahasiswaIds)->count(),
                'totalPengaduanProses' => Pengaduan::whereIn('mahasiswa_id', $mahasiswaIds)->where('status', 'proses')->count(),
                'totalTanggapan' => Tanggapan::whereIn('pengaduan_id', Pengaduan::whereIn('mahasiswa_id', $mahasiswaIds)->pluck('id'))->count(),
                // Statistik Bimbingan untuk Dosen
                'totalJadwalDibuat' => JadwalBimbingan::where('dosenpa_id', $dosenpaId)->count(),
                'totalPengajuanMasuk' => PendaftaranBimbingan::whereHas('jadwalBimbingan', function($q) use ($dosenpaId) {
                    $q->where('dosenpa_id', $dosenpaId);
                })->count(),
            ];
        }

        if ($user->role == 'mahasiswa') {
            $mahasiswaId = $user->mahasiswa->id;
            $data += [
                'totalPengaduanAnda' => Pengaduan::where('mahasiswa_id', $mahasiswaId)->count(),
                'totalPengaduanProses' => Pengaduan::where('mahasiswa_id', $mahasiswaId)->where('status', 'proses')->count(),
                'totalPengaduanSelesai' => Pengaduan::where('mahasiswa_id', $mahasiswaId)->where('status', 'selesai')->count(),
                'totalBimbingan' => PendaftaranBimbingan::where('mahasiswa_id', $mahasiswaId)->count(),
            ];
        }

        return view('dashboard.index', $data);
    }
}

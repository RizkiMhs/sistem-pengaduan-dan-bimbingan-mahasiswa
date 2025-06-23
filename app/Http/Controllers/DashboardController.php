<?php

namespace App\Http\Controllers;

use App\Models\Dosenpa;
use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Gunakan Model::count() untuk performa yang jauh lebih baik
        return view('dashboard.index', [
            'title'                 => 'Dashboard',
            'active'                => 'dashboard',
            'totalDosenpa'          => Dosenpa::count(),
            'totalMahasiswa'        => Mahasiswa::count(),
            'totalPengaduan'        => Pengaduan::count(),
            'totalPengaduanProses'  => Pengaduan::where('status', 'proses')->count(),
            'totalTanggapan'        => Tanggapan::count(),
        ]);

        // Catatan: Logika spesifik per user (yang Anda komentari)
        // juga bisa ditambahkan di sini dengan kondisi, contoh:
        //
        // if (auth()->user()->is_dosen) {
        //     $data['mahasiswaUntukDosen'] = Mahasiswa::where('dosenpa_id', auth()->user()->dosenpa->id)->count();
        // }
    }
}
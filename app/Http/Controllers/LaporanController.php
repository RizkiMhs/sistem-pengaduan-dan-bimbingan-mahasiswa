<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranBimbingan;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan dengan data yang sudah difilter.
     */
    public function index(Request $request)
    {
        // Atur rentang tanggal default ke bulan ini jika tidak ada input
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Ambil data Laporan Bimbingan sesuai rentang tanggal
        $laporanBimbingan = PendaftaranBimbingan::with(['mahasiswa', 'jadwalBimbingan.dosenpa'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->latest()->get();

        // Ambil data Laporan Pengaduan sesuai rentang tanggal
        $laporanPengaduan = Pengaduan::with(['mahasiswa', 'tanggapan.user'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->latest()->get();

        // Kirim semua data yang diperlukan ke view
        return view('dashboard.laporan.index', [
            'title' => 'Laporan',
            'active' => 'laporan',
            'laporanBimbingan' => $laporanBimbingan,
            'laporanPengaduan' => $laporanPengaduan,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}

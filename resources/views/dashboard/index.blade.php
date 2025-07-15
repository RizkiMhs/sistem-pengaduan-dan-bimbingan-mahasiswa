@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Selamat Datang, {{ Auth::user()->name }}</h1>
</div>

{{-- ================================================== --}}
{{-- Tampilan untuk ADMIN --}}
{{-- ================================================== --}}
@can('admin')
<div class="row gy-4">
    {{-- total dosen --}}
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="user-plus" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalDosenpa }}</h1>
                </div>
                Total Dosen PA
            </div>
        </div>
    </div>
     {{-- total mahasiswa --}}
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="users" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalMahasiswa }}</h1>
                </div>
                Total Mahasiswa
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="slack" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduan }}</h1>
                </div>
                Total Pengaduan Masuk
            </div>
        </div>
    </div>
    {{-- total pengaduan selesai --}}
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="check-circle" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalTanggapan }}</h1>
                </div>
                Total Pengaduan Selesai
            </div>
        </div>
    </div>
    {{-- total pengaduan proses --}}
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="alert-circle" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduanProses }}</h1>
                </div>
                Total Pengaduan Proses
            </div>
        </div>
    </div>
    {{-- total jadwal bimbingan --}}
    <div class="col-md-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="calendar" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalJadwalBimbingan }}</h1>
                </div>
                Total Jadwal Bimbingan
            </div>
        </div>
    </div>
</div>
@endcan

{{-- ================================================== --}}
{{-- Tampilan untuk DOSEN PA --}}
{{-- ================================================== --}}
@can('dosen_pa')
<div class="row gy-4">
    {{-- total mahasiswa bimbingan --}}
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="users" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalMahasiswa }}</h1>
                </div>
                Total Mahasiswa Bimbingan
            </div>
        </div>
    </div>
    {{-- total jadwal dibuat --}}
    <div class="col-md-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="calendar" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalJadwalDibuat }}</h1>
                </div>
                Total Jadwal Dibuat
            </div>
        </div>
    </div>
     {{-- total pengajuan masuk --}}
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="file-text" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengajuanMasuk }}</h1>
                </div>
                Total Pengajuan Masuk
            </div>
        </div>
    </div>
    {{-- PERUBAHAN: Kartu Statistik Pengaduan Ditambahkan Kembali --}}
    <div class="col-md-4">
        <div class="card bg-primary text-white" style="background-color: #6f42c1 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="slack" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduan }}</h1>
                </div>
                Total Pengaduan Masuk
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="check-circle" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalTanggapan }}</h1>
                </div>
                Total Pengaduan Selesai
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="alert-circle" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduanProses }}</h1>
                </div>
                Total Pengaduan Proses
            </div>
        </div>
    </div>
</div>
@endcan

{{-- ================================================== --}}
{{-- Tampilan untuk MAHASISWA --}}
{{-- ================================================== --}}
@can('mahasiswa')
<div class="row gy-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="send" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduanAnda }}</h1>
                </div>
                Total Pengaduan Anda
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="check-square" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduanSelesai }}</h1>
                </div>
                Pengaduan Selesai
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="clock" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalPengaduanProses }}</h1>
                </div>
                Pengaduan Diproses
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="calendar" style="width: 48px; height: 48px;"></span>
                    <h1 class="display-4">{{ $totalBimbingan }}</h1>
                </div>
                Total Pengajuan Bimbingan
            </div>
        </div>
    </div>
</div>
@endcan

@endsection

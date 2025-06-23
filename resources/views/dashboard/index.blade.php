@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Selamat Datang, {{ Auth::user()->name }} ( {{ Auth::user()->role }} )</h1>
</div>

{{-- total pengaduan masuk --}}
@can('admin')
<div class="row gap-3">
  {{-- total dosen --}}
  <div class="col-md-3">
      <div class="card bg-secondary text-white">
          <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                  <span data-feather="user-plus"></span>
                  <h1>{{ $totalDosenpa }}</h1>
              </div>
              Total Dosen PA
          </div>
      </div>
  </div>
      {{-- total mahasiswa --}}
      <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="users"></span>
                    <h1>{{ $totalMahasiswa }}</h1>
                </div>
                Total Mahasiswa
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="slack"></span>
                    <h1>{{ $totalPengaduan }}</h1>
                </div>
                Total Pengaduan Masuk
            </div>
        </div>
    </div>
    {{-- total pengaduan selesai --}}
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="check-circle"></span>
                    <h1>{{ $totalTanggapan }}</h1>
                </div>
                Total Pengaduan Selesai
            </div>
        </div>
    </div>

    {{-- total pengaduan proses --}}
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="alert-circle"></span>
                    <h1>{{ $totalPengaduanProses }}</h1>
                </div>
                Total Pengaduan Proses
            </div>
        </div>
    </div>
</div>
@endcan
@can('dosen_pa')
<div class="row gap-3">

      {{-- total mahasiswa --}}
      <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="users"></span>
                    <h1>{{ $totalMahasiswa }}</h1>
                </div>
                Total Mahasiswa
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="slack"></span>
                    <h1>{{ $totalPengaduan }}</h1>
                </div>
                Total Pengaduan Masuk
            </div>
        </div>
    </div>
    {{-- total pengaduan selesai --}}
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="check-circle"></span>
                    <h1>{{ $totalTanggapan }}</h1>
                </div>
                Total Pengaduan Selesai
            </div>
        </div>
    </div>

    {{-- total pengaduan proses --}}
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span data-feather="alert-circle"></span>
                    <h1>{{ $totalPengaduanProses }}</h1>
                </div>
                Total Pengaduan Proses
            </div>
        </div>
    </div>
</div>
@endcan

{{-- total pengaduan masuk --}}


{{-- modal view --}}

  

@endsection
@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan</h1>
</div>

{{-- Filter Form --}}
<div class="card mb-4">
    <div class="card-header">Filter Laporan</div>
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard.admin.laporan.index') }}">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-5">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Navigasi Tab --}}
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="bimbingan-tab" data-bs-toggle="tab" data-bs-target="#bimbingan" type="button" role="tab" aria-controls="bimbingan" aria-selected="true">Laporan Bimbingan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pengaduan-tab" data-bs-toggle="tab" data-bs-target="#pengaduan" type="button" role="tab" aria-controls="pengaduan" aria-selected="false">Laporan Pengaduan</button>
  </li>
</ul>

{{-- Konten Tab --}}
<div class="tab-content" id="myTabContent">
  {{-- Tab Laporan Bimbingan --}}
  <div class="tab-pane fade show active" id="bimbingan" role="tabpanel" aria-labelledby="bimbingan-tab">
    <div class="card card-body border-top-0">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Data Bimbingan dari {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h5>
            <button class="btn btn-success" onclick="window.print()"><span data-feather="printer"></span> Cetak</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Dosen PA</th>
                        <th>Topik</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanBimbingan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>{{ $item->mahasiswa->nama }}</td>
                        <td>{{ $item->mahasiswa->nim }}</td>
                        <td>{{ $item->jadwalBimbingan->dosenpa->nama }}</td>
                        <td>{{ $item->topik_mahasiswa }}</td>
                        <td><span class="badge bg-info">{{ $item->status_pengajuan }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data bimbingan pada rentang tanggal ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>

  {{-- Tab Laporan Pengaduan --}}
  <div class="tab-pane fade" id="pengaduan" role="tabpanel" aria-labelledby="pengaduan-tab">
     <div class="card card-body border-top-0">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Data Pengaduan dari {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h5>
            <button class="btn btn-success" onclick="window.print()"><span data-feather="printer"></span> Cetak</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-print">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pengaduan</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        {{-- <th>Kategori</th> --}}
                        <th>Status</th>
                        <th>Ditanggapi Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanPengaduan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>{{ $item->mahasiswa->nama }}</td>
                        <td>{{ $item->mahasiswa->nim }}</td>
                        {{-- <td>{{ $item->kategori }}</td> --}}
                        <td><span class="badge bg-info">{{ $item->status }}</span></td>
                        <td>{{ $item->tanggapan->dosenpa->nama ?? 'Belum Ditanggapi' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data pengaduan pada rentang tanggal ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<style>
@media print {
    body * {
        display: none !important;
        visibility: hidden !important;
    }
    .table-print, .table-print * {
        display: table !important;
        visibility: visible !important;
    }
    .table-print {
        position: static !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
        box-shadow: none !important;
    }
}
</style>
@endpush

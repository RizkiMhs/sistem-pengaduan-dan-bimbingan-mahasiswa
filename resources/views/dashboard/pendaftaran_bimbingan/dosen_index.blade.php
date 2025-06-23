@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pengajuan Bimbingan Masuk</h1>
</div>

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Daftar Pengajuan dari Mahasiswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Topik Ajuan</th>
                        <th scope="col">Jadwal Dipilih</th>
                        <th scope="col">Tgl. Pengajuan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pendaftaran->mahasiswa->nama }}</td>
                            <td>{{ $pendaftaran->topik_mahasiswa }}</td>
                            <td>{{ \Carbon\Carbon::parse($pendaftaran->jadwalBimbingan->waktu_mulai)->format('d M Y, H:i') }}</td>
                            <td>{{ $pendaftaran->created_at->format('d M Y') }}</td>
                            <td>
                                @if($pendaftaran->status_pengajuan == 'Diterima')
                                    <span class="badge bg-success">{{ $pendaftaran->status_pengajuan }}</span>
                                @elseif($pendaftaran->status_pengajuan == 'Ditolak')
                                    <span class="badge bg-danger">{{ $pendaftaran->status_pengajuan }}</span>
                                @elseif($pendaftaran->status_pengajuan == 'Selesai')
                                    <span class="badge bg-secondary">{{ $pendaftaran->status_pengajuan }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $pendaftaran->status_pengajuan }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol ini mengarah ke halaman detail pengajuan --}}
                                <a href="{{ route('dashboard.dosen.pengajuan-masuk.show', $pendaftaran->id) }}" class="badge bg-info"><span data-feather="eye"></span></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pengajuan bimbingan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

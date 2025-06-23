@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Bimbingan</h1>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <span data-feather="arrow-left"></span> Kembali
    </a>
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

<div class="row">
    {{-- Kolom Kiri: Detail Pengajuan & Hasil Bimbingan --}}
    <div class="col-lg-8">
        {{-- Card Detail Pengajuan --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Detail Pengajuan dari: <strong>{{ $pendaftaran->mahasiswa->nama }}</strong></span>
                @if($pendaftaran->status_pengajuan == 'Diterima')
                    <span class="badge bg-success">{{ $pendaftaran->status_pengajuan }}</span>
                @elseif($pendaftaran->status_pengajuan == 'Ditolak')
                    <span class="badge bg-danger">{{ $pendaftaran->status_pengajuan }}</span>
                @elseif($pendaftaran->status_pengajuan == 'Selesai')
                    <span class="badge bg-secondary">{{ $pendaftaran->status_pengajuan }}</span>
                @else
                    <span class="badge bg-warning text-dark">{{ $pendaftaran->status_pengajuan }}</span>
                @endif
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Topik Ajuan</dt>
                    <dd class="col-sm-8">{{ $pendaftaran->topik_mahasiswa }}</dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">{{ $pendaftaran->deskripsi_mahasiswa }}</dd>

                    <dt class="col-sm-4">Dokumen Pendukung</dt>
                    <dd class="col-sm-8">
                        @if ($pendaftaran->dokumen_mahasiswa)
                            <a href="{{ asset('storage/' . $pendaftaran->dokumen_mahasiswa) }}" target="_blank">Unduh Dokumen</a>
                        @else
                            <span class="text-muted">Tidak ada dokumen.</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Tampilkan card ini hanya jika bimbingan sudah diterima/selesai --}}
        @if($pendaftaran->status_pengajuan == 'Diterima' || $pendaftaran->status_pengajuan == 'Selesai')
        <div class="card mb-4">
            <div class="card-header">Hasil & Catatan Bimbingan</div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Catatan dari Dosen</dt>
                    <dd class="col-sm-8">{{ optional($pendaftaran->catatanBimbingan)->catatan_dosen ?? 'Belum ada catatan dari dosen.' }}</dd>

                    <dt class="col-sm-4">Dokumen Revisi</dt>
                    <dd class="col-sm-8">
                         @if (optional($pendaftaran->catatanBimbingan)->dokumen_revisi_dosen)
                            <a href="{{ asset('storage/' . $pendaftaran->catatanBimbingan->dokumen_revisi_dosen) }}" target="_blank">Unduh Dokumen Revisi</a>
                        @else
                            <span class="text-muted">Tidak ada dokumen.</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Catatan Konfirmasi Mahasiswa</dt>
                    <dd class="col-sm-8">{{ optional($pendaftaran->catatanBimbingan)->catatan_mahasiswa ?? 'Belum ada catatan dari mahasiswa.' }}</dd>
                </dl>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Form Aksi --}}
    <div class="col-lg-4">
        {{-- Card Info Jadwal --}}
        <div class="card mb-4">
            <div class="card-header">
                Informasi Jadwal
            </div>
             <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Dosen PA:</strong> {{ $pendaftaran->jadwalBimbingan->dosenpa->nama }}</li>
                <li class="list-group-item"><strong>Kategori:</strong> {{ $pendaftaran->jadwalBimbingan->kategoriBimbingan->nama_kategori }}</li>
                <li class="list-group-item"><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($pendaftaran->jadwalBimbingan->waktu_mulai)->format('l, d M Y, H:i') }}</li>
            </ul>
        </div>
        
        {{-- Form Aksi untuk Dosen PA --}}
        @can('dosen_pa')
            {{-- Form Terima/Tolak --}}
            @if ($pendaftaran->status_pengajuan == 'Diajukan')
            <div class="card mb-4">
                <div class="card-header">Tindak Lanjut Pengajuan</div>
                <div class="card-body text-center">
                    <p>Silakan terima atau tolak pengajuan bimbingan ini.</p>
                    <form action="{{ route('dashboard.dosen.pengajuan-masuk.update', $pendaftaran->id) }}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <input type="hidden" name="status_pengajuan" value="Ditolak">
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                    <form action="{{ route('dashboard.dosen.pengajuan-masuk.update', $pendaftaran->id) }}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <input type="hidden" name="status_pengajuan" value="Diterima">
                        <button type="submit" class="btn btn-success">Terima</button>
                    </form>
                </div>
            </div>
            @endif

            {{-- PERUBAHAN: Form Isi Catatan Bimbingan untuk Dosen --}}
            @if ($pendaftaran->status_pengajuan == 'Diterima' || $pendaftaran->status_pengajuan == 'Selesai')
            <div class="card">
                <div class="card-header">Form Catatan (Dosen)</div>
                <div class="card-body">
                    <form action="{{ route('dashboard.catatan-bimbingan.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id }}">
                        <div class="mb-3">
                            <label for="catatan_dosen" class="form-label">Catatan/Feedback</label>
                            <textarea name="catatan_dosen" class="form-control" rows="5" required>{{ old('catatan_dosen', optional($pendaftaran->catatanBimbingan)->catatan_dosen ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_revisi_dosen" class="form-label">Upload Dokumen Revisi (Opsional)</label>
                            <input type="file" name="dokumen_revisi_dosen" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Catatan & Selesaikan</button>
                    </form>
                </div>
            </div>
            @endif
        @endcan

        {{-- PERUBAHAN: Form Isi Catatan Bimbingan untuk Mahasiswa --}}
        @can('mahasiswa')
            @if ($pendaftaran->status_pengajuan == 'Selesai')
            <div class="card">
                <div class="card-header">Form Catatan Konfirmasi</div>
                <div class="card-body">
                    <form action="{{ route('dashboard.catatan-bimbingan.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id }}">
                        <div class="mb-3">
                            <label for="catatan_mahasiswa" class="form-label">Catatan Konfirmasi</label>
                            <textarea name="catatan_mahasiswa" class="form-control" rows="5" placeholder="Contoh: Baik, Pak/Bu. Catatan sudah saya terima dan akan segera saya perbaiki.">{{ old('catatan_mahasiswa', optional($pendaftaran->catatanBimbingan)->catatan_mahasiswa ?? '') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Konfirmasi</button>
                    </form>
                </div>
            </div>
            @endif
        @endcan
    </div>
</div>
@endsection

@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Jadwal Bimbingan Anda</h1>
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addJadwal">
    Buat Jadwal Bimbingan Baru
</button>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Topik Umum</th>
                <th scope="col">Kategori</th>
                <th scope="col">Waktu Bimbingan</th>
                <th scope="col">Kuota</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalBimbingans as $jadwal)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $jadwal->topik_umum }}</td>
                    <td>{{ $jadwal->kategoriBimbingan->nama_kategori }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('d M Y, H:i') }}</td>
                    <td>{{ $jadwal->pendaftaranBimbingan->count() }} / {{ $jadwal->kuota_per_hari }}</td>
                    <td><span class="badge {{ $jadwal->status == 'Tersedia' ? 'bg-success' : 'bg-secondary' }}">{{ $jadwal->status }}</span></td>
                    <td>
                        <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editJadwal{{ $jadwal->id }}"><span data-feather="edit"></span></button>
                        
                        <form action="/dashboard/jadwal-bimbingan/{{ $jadwal->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Anda yakin ingin menghapus jadwal ini?')"><span data-feather="trash-2"></span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addJadwal" tabindex="-1" aria-labelledby="addJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJadwalLabel">Buat Jadwal Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/dashboard/jadwal-bimbingan">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori_bimbingan_id" class="form-label">Kategori Bimbingan</label>
                        <select class="form-select @error('kategori_bimbingan_id') is-invalid @enderror" name="kategori_bimbingan_id" required>
                            <option value="" selected disabled>Pilih Kategori...</option>
                            @foreach ($kategoriBimbingans as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_bimbingan_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_bimbingan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="topik_umum" class="form-label">Topik Umum</label>
                        <input type="text" class="form-control @error('topik_umum') is-invalid @enderror" name="topik_umum" value="{{ old('topik_umum') }}" required>
                        @error('topik_umum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" class="form-control @error('waktu_mulai') is-invalid @enderror" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                        @error('waktu_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                     <div class="mb-3">
                        <label for="kuota_per_hari" class="form-label">Kuota per Hari</label>
                        <input type="number" class="form-control @error('kuota_per_hari') is-invalid @enderror" name="kuota_per_hari" value="{{ old('kuota_per_hari', 3) }}" required min="1">
                        @error('kuota_per_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Awal</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="Tersedia" selected>Tersedia</option>
                            <option value="Ditutup">Ditutup</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach ($jadwalBimbingans as $jadwal)
<div class="modal fade" id="editJadwal{{ $jadwal->id }}" tabindex="-1" aria-labelledby="editJadwalLabel{{ $jadwal->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJadwalLabel{{ $jadwal->id }}">Edit Jadwal Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/dashboard/jadwal-bimbingan/{{ $jadwal->id }}">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="kategori_bimbingan_id" class="form-label">Kategori Bimbingan</label>
                        <select class="form-select" name="kategori_bimbingan_id" required>
                            @foreach ($kategoriBimbingans as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_bimbingan_id', $jadwal->kategori_bimbingan_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="topik_umum" class="form-label">Topik Umum</label>
                        <input type="text" class="form-control" name="topik_umum" value="{{ old('topik_umum', $jadwal->topik_umum) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" class="form-control" name="waktu_mulai" value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kuota_per_hari" class="form-label">Kuota per Hari</label>
                        <input type="number" class="form-control" name="kuota_per_hari" value="{{ old('kuota_per_hari', $jadwal->kuota_per_hari) }}" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Tersedia" {{ old('status', $jadwal->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Penuh" {{ old('status', $jadwal->status) == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                            <option value="Ditutup" {{ old('status', $jadwal->status) == 'Ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

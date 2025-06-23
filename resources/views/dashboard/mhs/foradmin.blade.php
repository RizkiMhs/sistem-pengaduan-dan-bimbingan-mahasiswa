@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Mahasiswa</h1>
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
{{-- Tombol ini bisa diatur hak aksesnya jika diperlukan --}}
<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addmhs">
    Tambah Mahasiswa
</button>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">NIM</th>
                <th scope="col">Program Studi</th>
                <th scope="col">Dosen PA</th>
                <th scope="col">Foto</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswa as $mhs)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->nim }}</td>
                    {{-- Menampilkan nama prodi dari relasi --}}
                    <td>{{ $mhs->prodi->nama_prodi ?? 'N/A' }}</td>
                    {{-- Menampilkan nama dosen dari relasi --}}
                    <td>{{ $mhs->dosenpa->nama ?? 'N/A' }}</td>
                    <td>
                        @if ($mhs->foto)
                            <img src="{{ asset('storage/' . $mhs->foto) }}" alt="foto" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">
                        @else
                            <img src="https://placehold.co/50x50/666/fff?text=N/A" alt="foto" style="width: 50px" class="img-thumbnail">
                        @endif
                    </td>
                    <td>
                        <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showmhs{{ $mhs->id }}"><span data-feather="eye"></span></button>
                        <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editmhs{{ $mhs->id }}"><span data-feather="edit"></span></button>
                        <form action="/dashboard/mahasiswa-admin/{{ $mhs->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="trash-2"></span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal show Mahasiswa -->
@foreach ($mahasiswa as $mhs)
<div class="modal fade" id="showmhs{{ $mhs->id }}" tabindex="-1" aria-labelledby="showmhsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showmhsLabel">Detail Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                         @if ($mhs->foto)
                            <img src="{{ asset('storage/' . $mhs->foto) }}" class="img-fluid rounded" alt="{{ $mhs->foto }}">
                        @else
                            <img src="https://placehold.co/200x200/666/fff?text=N/A" class="img-fluid rounded" alt="Tidak ada foto">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr><td>Nama</td><td>:</td><td>{{ $mhs->nama }}</td></tr>
                                <tr><td>NIM</td><td>:</td><td>{{ $mhs->nim }}</td></tr>
                                {{-- Mengganti Tingkat dengan Prodi --}}
                                <tr><td>Program Studi</td><td>:</td><td>{{ $mhs->prodi->nama_prodi ?? 'N/A' }} ({{ $mhs->prodi->jenjang ?? 'N/A' }})</td></tr>
                                <tr><td>Fakultas</td><td>:</td><td>{{ $mhs->prodi->fakultas->nama_fakultas ?? 'N/A' }}</td></tr>
                                <tr><td>Dosen PA</td><td>:</td><td>{{ $mhs->dosenpa->nama ?? 'N/A' }}</td></tr>
                                <tr><td>Email</td><td>:</td><td>{{ $mhs->user->email ?? $mhs->email }}</td></tr>
                                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $mhs->jenis_kelamin }}</td></tr>
                                <tr><td>Nomor HP</td><td>:</td><td>{{ $mhs->no_hp }}</td></tr>
                                <tr><td>Alamat</td><td>:</td><td>{{ $mhs->alamat }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal add Mahasiswa -->
<div class="modal fade" id="addmhs" tabindex="-1" aria-labelledby="addmhsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addmhsLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/dashboard/mahasiswa-admin" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label for="nama" class="form-label">Nama</label><input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="nim" class="form-label">NIM</label><input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>@error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="prodi_id" class="form-label">Program Studi</label><select class="form-select @error('prodi_id') is-invalid @enderror" name="prodi_id" required><option value="" selected disabled>Pilih Program Studi...</option>@foreach ($prodi as $p)<option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }} ({{ $p->jenjang }})</option>@endforeach</select>@error('prodi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="dosenpa_id" class="form-label">Dosen PA</label><select class="form-select @error('dosenpa_id') is-invalid @enderror" name="dosenpa_id" required><option value="" selected disabled>Pilih Dosen PA...</option>@foreach ($dosenpa as $dosen)<option value="{{ $dosen->id }}" {{ old('dosenpa_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>@endforeach</select>@error('dosenpa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="jenis_kelamin" class="form-label">Jenis Kelamin</label><select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required><option value="" selected disabled>Pilih Jenis Kelamin...</option><option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select>@error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="no_hp" class="form-label">Nomor HP</label><input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>@error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>@error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="foto" class="form-label">Foto</label><input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">@error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit Mahasiswa -->
@foreach ($mahasiswa as $mhs)
<div class="modal fade" id="editmhs{{ $mhs->id }}" tabindex="-1" aria-labelledby="editmhsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editmhsLabel">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/dashboard/mahasiswa-admin/{{ $mhs->id }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="mb-3"><label for="nama" class="form-label">Nama</label><input type="text" class="form-control" name="nama" value="{{ $mhs->nama }}" required></div>
                    <div class="mb-3"><label for="nim" class="form-label">NIM</label><input type="text" class="form-control" name="nim" value="{{ $mhs->nim }}" required></div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ $mhs->user->email ?? $mhs->email }}" required></div>
                    <div class="mb-3"><label for="prodi_id" class="form-label">Program Studi</label><select class="form-select" name="prodi_id" required><option disabled>Pilih Program Studi...</option>@foreach ($prodi as $p)<option value="{{ $p->id }}" {{ $mhs->prodi_id == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }} ({{ $p->jenjang }})</option>@endforeach</select></div>
                    <div class="mb-3"><label for="dosenpa_id" class="form-label">Dosen PA</label><select class="form-select" name="dosenpa_id" required><option disabled>Pilih Dosen PA...</option>@foreach ($dosenpa as $dosen)<option value="{{ $dosen->id }}" {{ $mhs->dosenpa_id == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>@endforeach</select></div>
                    <div class="mb-3"><label for="jenis_kelamin" class="form-label">Jenis Kelamin</label><select class="form-select" name="jenis_kelamin" required><option disabled>Pilih Jenis Kelamin...</option><option value="Laki-laki" {{ $mhs->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ $mhs->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div>
                    <div class="mb-3"><label for="no_hp" class="form-label">Nomor HP</label><input type="text" class="form-control" name="no_hp" value="{{ $mhs->no_hp }}" required></div>
                    <div class="mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control" name="alamat" required>{{ $mhs->alamat }}</textarea></div>
                    <div class="mb-3"><label for="foto" class="form-label">Foto</label>@if($mhs->foto)<img src="{{ asset('storage/' . $mhs->foto) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">@endif<input type="file" class="form-control" name="foto"></div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

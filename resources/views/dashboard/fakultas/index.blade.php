

@extends('dashboard.layouts.main')  

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Fakultas</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#addfakultas">
                    Tambah Fakultas
                </button>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="table">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Fakultas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fakultas as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nama_fakultas }}</td>
                    <td>
                        {{-- <a href="/dashboard/kelas/{{ $item->id }}" class="badge bg-info"><span data-feather="eye"></span></a> --}}
                        {{-- <a href="/dashboard/kelas/{{ $item->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a> --}}
                        {{-- TOMBOL SHOW DITAMBAHKAN DI SINI --}}
                        <button class="badge bg-info border-0" data-bs-toggle="modal" data-bs-target="#showfakultas{{ $item->id }}"><span data-feather="eye"></span></button>
                        <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editfakultas{{ $item->id }}"><span data-feather="edit"></span></button>
                        <form action="/dashboard/fakultas/{{ $item->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Apakah anda yakin?')"><span data-feather="x-circle"></span></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addfakultas" tabindex="-1" aria-labelledby="addkelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addkelasLabel">Tambah Fakultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/dashboard/fakultas">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
                            <input type="text" class="form-control @error('nama_fakultas') is-invalid @enderror" id="nama_fakultas" name="nama_fakultas" required value="{{ old('nama_fakultas') }}">
                            @error('nama_fakultas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    @foreach($fakultas as $item)
    <div class="modal fade" id="editfakultas{{ $item->id }}" tabindex="-1" aria-labelledby="editfakultasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editfakultasLabel">Edit Fakultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/dashboard/fakultas/{{ $item->id }}">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
                            <input type="text" class="form-control @error('nama_fakultas') is-invalid @enderror" id="nama_fakultas" name="nama_fakultas" required value="{{ $item->nama_fakultas }}">
                            @error('nama_fakultas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-warning">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    {{-- MODAL SHOW (BAGIAN BARU) --}}
    @foreach($fakultas as $item)
    <div class="modal fade" id="showfakultas{{ $item->id }}" tabindex="-1" aria-labelledby="showfakultasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showfakultasLabel">Detail Fakultas: {{ $item->nama_fakultas }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Daftar Program Studi (Prodi)</h6>
                    
                    {{-- Memeriksa apakah ada data prodi terkait --}}
                    @if ($item->prodi && $item->prodi->count() > 0)
                        <table class="table table-sm table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Prodi</th>
                                    <th scope="col">Jenjang</th> {{-- Asumsi kolom jenjang ada di tabel prodi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->prodi as $prodi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- Sesuaikan 'nama_prodi' dan 'jenjang' jika nama kolom Anda berbeda --}}
                                        <td>{{ $prodi->nama_prodi }}</td> 
                                        <td>{{ $prodi->jenjang }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Fakultas ini belum memiliki Program Studi yang terdaftar.</p>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

@endsection
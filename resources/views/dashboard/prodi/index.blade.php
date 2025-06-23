@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Program Studi</h1>
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
    <button type="button" class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#addProdi">
        Tambah Program Studi
    </button>

    <div class="table-responsive mt-3">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Program Studi</th>
                    <th scope="col">Jenjang</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prodi as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nama_prodi }}</td>
                    <td>{{ $item->jenjang }}</td>
                    <td>{{ $item->fakultas->nama_fakultas }}</td>
                    <td>
                        <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editProdi{{ $item->id }}"><span data-feather="edit"></span></button>
                        
                        <form action="/dashboard/prodi/{{ $item->id }}" method="post" class="d-inline">
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

    <!-- Modal Add -->
    <div class="modal fade" id="addProdi" tabindex="-1" aria-labelledby="addProdiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProdiLabel">Tambah Program Studi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/dashboard/prodi">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi" name="nama_prodi" required value="{{ old('nama_prodi') }}">
                            @error('nama_prodi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        {{-- PERUBAHAN: Input Jenjang menjadi Select --}}
                        <div class="mb-3">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <select class="form-select @error('jenjang') is-invalid @enderror" name="jenjang" id="jenjang" required>
                                <option value="" selected disabled>Pilih Jenjang...</option>
                                <option value="D3" {{ old('jenjang') == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('jenjang') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('jenjang') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('jenjang') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('jenjang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fakultas_id" class="form-label">Fakultas</label>
                            <select class="form-select @error('fakultas_id') is-invalid @enderror" name="fakultas_id" required>
                                <option value="" selected disabled>Pilih Fakultas...</option>
                                @foreach ($fakultas as $fk)
                                    <option value="{{ $fk->id }}" {{ old('fakultas_id') == $fk->id ? 'selected' : '' }}>{{ $fk->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            @error('fakultas_id')
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

    <!-- Modal Edit -->
    @foreach($prodi as $item)
    <div class="modal fade" id="editProdi{{ $item->id }}" tabindex="-1" aria-labelledby="editProdiLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProdiLabel{{ $item->id }}">Edit Program Studi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/dashboard/prodi/{{ $item->id }}">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="nama_prodi_edit_{{ $item->id }}" class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi_edit_{{ $item->id }}" name="nama_prodi" required value="{{ old('nama_prodi', $item->nama_prodi) }}">
                            @error('nama_prodi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        {{-- PERUBAHAN: Input Jenjang menjadi Select --}}
                        <div class="mb-3">
                            <label for="jenjang_edit_{{ $item->id }}" class="form-label">Jenjang</label>
                            <select class="form-select @error('jenjang') is-invalid @enderror" name="jenjang" id="jenjang_edit_{{ $item->id }}" required>
                                <option value="" disabled>Pilih Jenjang...</option>
                                <option value="D3" {{ old('jenjang', $item->jenjang) == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('jenjang', $item->jenjang) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('jenjang', $item->jenjang) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('jenjang', $item->jenjang) == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('jenjang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fakultas_id_edit_{{ $item->id }}" class="form-label">Fakultas</label>
                            <select class="form-select @error('fakultas_id') is-invalid @enderror" name="fakultas_id" required>
                                <option value="" disabled>Pilih Fakultas...</option>
                                @foreach ($fakultas as $fk)
                                    <option value="{{ $fk->id }}" {{ old('fakultas_id', $item->fakultas_id) == $fk->id ? 'selected' : '' }}>{{ $fk->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            @error('fakultas_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Mahasiswa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        @can('dosen_pa')
        <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#addmhs">
          Tambah Mahasiswa
        </button>
        @endcan
      </div>
  </div>
  </div>

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif





<!-- Button trigger modal -->
{{-- @can('dosen_pa')
<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addmhs">
  Tambah Mahasiswa
</button>
@endcan --}}
  
<div class="table">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Nim</th>
          <th scope="col">Kelas</th>
          <th scope="col">Email</th>
          <th scope="col">Dosen PA</th>
          <th scope="col">Foto</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($mahasiswa as $mhs)
        @if ($mhs->dosenpa_id == Auth::user()->dosenpa->id)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->nim }}</td>
            {{-- <td>{{ $mhs->tingkat->nama_kelas }}</td> --}}

            <td>
              @foreach ($tingkat as $item)
                @if ($item->id == $mhs->id_tingkat)
                  {{ $item->nama_kelas }}({{ $item->angkatan }})
                @endif
              @endforeach  
            </td>
            <td>{{ $mhs->email }}</td>
            <td>{{ $mhs->dosenpa->nama }}</td>
            <td><img src="{{ asset('storage/' . $mhs->foto) }}" alt="foto" style="width: 50px" class="img-thumbnail"></td>
            <td>
  
              <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showmhs{{ $mhs->id }}"><span data-feather="eye"></span></button>

              @can('dosen_pa')
              <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editmhs{{ $mhs->id }}"><span data-feather="edit"></span></button>

              <form action="/dashboard/mahasiswa/{{ $mhs->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="trash-2"></span></button>
              </form>
              @endcan
            </td>
          </tr>
        @endif
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
                <div class="col-md-4">
                  <img src="{{ asset('storage/' . $mhs->foto) }}" class="img-thumbnail rounded-start" alt="{{ $mhs->foto }}">                 
                  
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <table class="table">
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $mhs->nama }}</td>
                      </tr>
                      <tr>
                        <td>Nim</td>
                        <td>:</td>
                        <td>{{ $mhs->nim }}</td>
                      </tr>
                      <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $mhs->jenis_kelamin }}</td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $mhs->alamat }}</td>
                      </tr>
                      <tr>
                        <td>Nomor HP</td>
                        <td>:</td>
                        <td>{{ $mhs->no_hp }}</td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>
                          @foreach ($tingkat as $item)
                            @if ($item->id == $mhs->id_tingkat)
                              {{ $item->nama_kelas }}({{ $item->angkatan }})
                            @endif
                          @endforeach
                        </td>
                      </tr>
                      
                      <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $mhs->email }}</td>
                      </tr>
                      <tr>
                        <td>Dosen PA</td>
                        <td>:</td>
                        <td>{{ $mhs->dosenpa->nama }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <!-- Modal add Mahasiswa -->


  <div class="modal fade" id="addmhs" tabindex="-1" aria-labelledby="addmhsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addmhsLabel">Tambah Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="/dashboard/mahasiswa" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                  @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="nim" class="form-label">Nim</label>
                  <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}">
                  @error('nim')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-select" name="jenis_kelamin" @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" value="{{ old('jenis_kelamin') }}">
                    <option selected>Pilih Jenis Kelamin</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                  </select>              
                </div>
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  {{-- <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}"> --}}
                  <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}"></textarea>
                  @error('alamat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="no_hp" class="form-label">Nomor HP</label>
                  <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
                  @error('no_hp')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="tingkat_id" class="form-label">Kelas</label>
                  <select class="form-select" name="id_tingkat">
                    <option selected>Pilih Kelas</option>
                    @foreach ($tingkat as $item)
                      <option value="{{ $item->id }}">{{ $item->nama_kelas }}({{ $item->angkatan }})</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                  @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Password Confirmation</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password_confirmation">
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="foto" class="form-label">Foto</label>
                  <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
                  @error('foto')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            {{-- <button type="submit" class="btn btn-primary">Tambah</button> --}}
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal edit Mahasiswa -->
  @foreach ($mahasiswa as $mhs)
  <div class="modal fade" id="editmhs{{ $mhs->id }}" tabindex="-1" aria-labelledby="editmhsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editmhsLabel">Edit Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="/dashboard/mahasiswa/{{ $mhs->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row">
              <div class="col-md-6">
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $mhs->nama }}">
                  @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="nim" class="form-label">Nim</label>
                  <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ $mhs->nim }}">
                  @error('nim')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-select" name="jenis_kelamin" @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" value="{{ $mhs->jenis_kelamin }}">
                    <option selected>Pilih Jenis Kelamin</option>
                    <option value="laki-laki" {{ $mhs->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ $mhs->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  {{-- <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ $mhs->alamat }}"> --}}
                  <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ $mhs->alamat }}"></textarea>
                  @error('alamat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="no_hp" class="form-label">Nomor HP</label>
                  <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ $mhs->no_hp }}">
                  @error('no_hp')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

              </div>
              <div class="col-md-6">

                <div class="mb-3">
                  <label for="tingkat_id" class="form-label">Kelas</label>
                  <select class="form-select" name="id_tingkat">
                    @foreach ($tingkat as $item)
                      <option value="{{ $item->id }}" {{ $item->id == $mhs->id_tingkat ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $mhs->email }}">
                  @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="dosenpa_id" class="form-label">Dosen PA</label>
                  <select class="form-select" name="dosenpa_id">
                    @foreach ($dosenpa as $dosen)
                      <option value="{{ $dosen->id }}" {{ $dosen->id == $mhs->dosenpa_id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                    @endforeach 
                  </select>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="foto" class="form-label">Foto</label>
                  <img src="{{ asset('storage/' . $mhs->foto) }}" alt="foto" style="width: 100px" class="img-thumbnail d-flex mb-2">
                  <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
                  @error('foto')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Edit</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            {{-- <button type="submit" class="btn btn-primary">Edit</button> --}}
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

@endsection
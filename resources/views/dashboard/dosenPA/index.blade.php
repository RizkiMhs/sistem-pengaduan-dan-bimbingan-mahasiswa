@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Dosen PA</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-primary mt-3 " data-bs-toggle="modal" data-bs-target="#adddosen">
          Tambah
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





<!-- Button trigger modal -->

  
<div class="table">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Nip</th>
          <th scope="col">Email</th>
          <th scope="col">Prodi</th>
          <th scope="col">Fakultas</th>
          <th scope="col">Foto</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dosenpa as $pa)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $pa->nama }}</td>
            <td>{{ $pa->nidn }}</td>
            <td>{{ $pa->email }}</td>
            <td>{{ $pa->prodi->nama_prodi ?? '-' }}</td>
            <td>{{ $pa->prodi->fakultas->nama_fakultas ?? '-' }}</td>
            <td><img src="{{ asset('storage/' . $pa->foto) }}" alt="foto" style="width: 50px" class="img-thumbnail"></td>
            <td>
  
              {{-- <a href="/dashboard/user/{{ $user->id }}" class="badge bg-info"><span data-feather="eye"></span></a> --}}
              {{-- <a href="/dashboard/user/{{ $user->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a> --}}
              <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showdosen{{ $pa->id }}"><span data-feather="eye"></span></button>
              <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editdosen{{ $pa->id }}"><span data-feather="edit"></span></button>
              {{-- <a href="/dashboard/user/{{ $user->id }}">
              </a> --}}
              <form action="/dashboard/dosen-pa/{{ $pa->id }}" method="post" class="d-inline">
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


<!-- Modal add -->

<div class="modal fade" id="adddosen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Dosen PA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  method="post" action="/dashboard/dosen-pa" enctype="multipart/form-data" >
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
                <label for="nidn" class="form-label">NIDN</label>
                <input type="text" class="form-control @error('nidn') is-invalid @enderror" id="nidn" name="nidn" value="{{ old('nidn') }}">
                @error('nidn')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                {{-- <input type="text" class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" value="{{ old('jenis_kelamin') }}"> --}}
                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                  <option selected>Pilih Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
                @error('jenis_kelamin')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                {{-- <input type="text" class="form-control @error('nidn') is-invalid @enderror" id="nidn" name="nidn" value="{{ old('nidn') }}"> --}}
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="prodi_id" class="form-label">Program Studi</label>
                <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                  <option value="">Pilih Program Studi</option>
                  @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})</option>
                  @endforeach
                </select>
                @error('prodi_id')
                  <div class="invalid-feedback">{{ $message }}</div>
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
                    <label for="foto" class="form-label" >Upload Foto</label>
                    <input type="file" class="form-control  @error('foto') is-invalid @enderror" id="inputGroupFile02" name="foto">
                    {{-- <label class="input-group-text" for="inputGroupFile02">Upload</label> --}}
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

<!-- Modal edit -->

@foreach ($dosenpa as $pa)
<div class="modal fade" id="editdosen{{ $pa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Dosen PA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form  method="post" action="/dashboard/dosen-pa/{{ $pa->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $pa->nama }}">
                    @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nidn" class="form-label">NIDN</label>
                    <input type="text" class="form-control @error('nidn') is-invalid @enderror" id="nidn" name="nidn" value="{{ $pa->nidn }}">
                    @error('nidn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                        <option selected>{{ $pa->jenis_kelamin }}</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ $pa->alamat }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="prodi_id" class="form-label">Program Studi</label>
                  <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                    <option value="">Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                      <option value="{{ $prodi->id }}" {{ $pa->prodi_id == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})</option>
                    @endforeach
                  </select>
                  @error('prodi_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ $pa->no_hp }}">
                    @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $pa->email }}">
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
                        <label for="foto" class="form-label" >Upload Foto</label>
                        @if ($pa->foto)
                        <img src="{{ asset('storage/' . $pa->foto) }}" alt="foto" style="width: 100px" class="img-thumbnail d-flex mb-1">
                        @endif
                        <input type="file" class="form-control" id="inputGroupFile02" name="foto">
                        {{-- <label class="input-group-text" for="inputGroupFile02">Upload</label> --}}
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

<!-- Modal show -->
@foreach ($dosenpa as $pa)
<div class="modal fade" id="showdosen{{ $pa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Dosen PA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-0">
                <div class="col-md-4">
                  <img src="{{ asset('storage/' . $pa->foto) }}" class="img-thumbnail rounded-start" alt="{{ $pa->foto }}">                  
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                      
                      <table class="table">
                          <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>{{ $pa->nama }}</td>
                          </tr>
                          <tr>
                              <td>NIDN</td>
                              <td>:</td>
                              <td>{{ $pa->nidn }}</td>
                          </tr>
                          <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>{{ $pa->email }}</td>
                          </tr>
                          <tr>
                              <td>Jenis Kelamin</td>
                              <td>:</td>
                              <td>{{ $pa->jenis_kelamin }}</td>
                          </tr>
                          <tr>
                              <td>Alamat</td>
                              <td>:</td>
                              <td>{{ $pa->alamat }}</td>
                          </tr>
                          <tr>
                              <td>Nomor HP</td>
                              <td>:</td>
                              <td>{{ $pa->no_hp }}</td>
                          </tr>                                   
                      </table>

                      {{-- AWAL BAGIAN TAMBAHAN --}}
                      <h6 class="mt-4">Daftar Mahasiswa Bimbingan:</h6>
                      
                      @if ($pa->mahasiswa && $pa->mahasiswa->count() > 0)
                        <table class="table table-sm table-striped mt-2">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama Mahasiswa</th>
                              {{-- Ganti 'nim' dengan nama kolom yang sesuai jika berbeda --}}
                              <th scope="col">NIM</th> 
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($pa->mahasiswa as $mahasiswa)
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <p class="text-muted mt-2">Belum ada mahasiswa bimbingan.</p>
                      @endif
                      {{-- AKHIR BAGIAN TAMBAHAN --}}

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
        


@endsection
@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Mahasiswa</h1>
    {{-- <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        @can('dosen_pa')
        <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#addmhs">
          Tambah Mahasiswa
        </button>
        @endcan
      </div>
  </div> --}}
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
          <th scope="col">Prodi</th>
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
              @foreach ($prodi as $item)
                @if ($item->id == $mhs->prodi_id)
                  {{ $item->nama_prodi }} ({{ $item->jenjang }})
                @endif
              @endforeach
            </td>
            {{-- <td>{{ $mhs->email }}</td> --}}
            <td>{{ $mhs->dosenpa->nama }}</td>
            <td><img src="{{ asset('storage/' . $mhs->foto) }}" alt="foto" style="width: 50px" class="img-thumbnail"></td>
            <td>
  
              <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showmhs{{ $mhs->id }}"><span data-feather="eye"></span></button>

              {{-- @can('dosen_pa')
              <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editmhs{{ $mhs->id }}"><span data-feather="edit"></span></button>

              <form action="/dashboard/mahasiswa/{{ $mhs->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="trash-2"></span></button>
              </form>
              @endcan --}}
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
              @foreach ($prodi as $item)
                @if ($item->id == $mhs->prodi_id)
                  {{ $item->nama_prodi }} ({{ $item->jenjang }})
                @endif
              @endforeach
            </td>
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

@endsection
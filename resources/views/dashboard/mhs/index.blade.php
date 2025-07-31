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
          <th>#</th>
          <th>Nama</th>
          <th>NIM</th>
          <th>Program Studi</th>
          <th>Fakultas</th>
          <th>Dosen PA</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($mahasiswa as $mhs)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
            <td>{{ $mhs->prodi->fakultas->nama_fakultas ?? '-' }}</td>
            <td>{{ $mhs->dosenpa->nama ?? '-' }}</td>
            <td>
              @if($mhs->foto)
                <img src="{{ asset('storage/'.$mhs->foto) }}" alt="foto" width="50">
              @else
                <span>foto</span>
              @endif
            </td>
            <td>
              <!-- aksi -->
              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showmhs{{ $mhs->id }}">
                <span data-feather="eye"></span>
              </button>
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
                        <td>Fakultas</td>
                        <td>:</td>
                        <td>{{ $mhs->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                      </tr>
                      <tr>
                        <td>Program Studi</td>
                        <td>:</td>
                        <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
            
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
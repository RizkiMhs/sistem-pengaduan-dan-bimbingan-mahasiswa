@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Pengaduan</h1>
  </div>

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIM</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Isi Pengaduan</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduan as $item)
            @if ($item->status == 'proses' || $item->status == 'tolak')
            @if ($item->mahasiswa->dosenpa_id == Auth::user()->dosenpa->id)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->mahasiswa->nim }}</td>
                <td>{{ $item->mahasiswa->nama }}</td>
                <td>{{ $item->isi_pengaduan }}</td>
                <td>
                    @if ($item->status == 'proses')
                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                    @elseif ($item->status == 'tolak')
                    <span class="badge bg-danger">{{ $item->status }}</span>
                    @else
                    <span class="badge bg-success">{{ $item->status }}</span>
                    @endif
                </td>
                <td>
                    <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showpengaduan{{ $item->id }}"><span data-feather="eye"></span></button>
                                 {{-- <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showpengaduan{{ $item->id }}"><span data-feather="eye"></span></button> --}}


                </td>
            </tr>
            @endif
            @endif
            @endforeach
        </tbody>
    </table>
</div>

{{-- modal view --}}
@foreach ($pengaduan as $item)
<div class="modal fade" id="showpengaduan{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        {{-- <p><strong>Nama:</strong> {{ $item->mahasiswa->nama }}</p>
                        <p><strong>NIM:</strong> {{ $item->mahasiswa->nim }}</p> --}}
                        <div class="mb-2">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ $item->mahasiswa->nim }}" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="nama" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $item->mahasiswa->nama }}" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="isi_pengaduan" class="form-label">Isi Pengaduan</label>
                            <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" rows="3" readonly>{{ $item->isi_pengaduan }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label for="dokumen" class="form-label">Dokumen</label>
                            @if($item->dokumen)
                                @php
                                    $ext = pathinfo($item->dokumen, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                    <img src="{{ asset('storage/' . $item->dokumen) }}" alt="Dokumen" class="img-thumbnail" width="200">
                                @else
                                    <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank">Lihat / Download Dokumen</a>
                                @endif
                            @else
                                <span class="text-muted">Tidak ada dokumen.</span>
                            @endif
                        </div>
                        <p><strong>Tanggal Masuk:</strong> {{ $item->created_at }}</p>
                    </div>
                    <div class="col-md-6">

                    <h5 class="card-title">Isi Tanggapan</h5>

                    <form action="/dashboard/tanggapan" method="post">
                        @csrf
                        <input type="hidden" name="pengaduan_id" value="{{ $item->id }}">
                        <div class="mb-2">
                            <textarea class="form-control" id="isi_tanggapan" name="isi_tanggapan" rows="6"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                    </form>
                    
                    
                    
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
                <form action="/dashboard/pengaduan-dosen" method="post">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $item->id }}">   
                    <button type="submit" class="btn btn-danger">Tolak</button>                        
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
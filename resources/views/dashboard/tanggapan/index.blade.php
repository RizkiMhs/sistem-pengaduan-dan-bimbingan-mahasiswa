@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Pengaduan</h1>
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
                <th scope="col">isi Tanggapan</th>
                <th scope="col">Tanggal Masuk</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tanggapan as $item)
            @if ($item->pengaduan->status == 'selesai')
            @if($item->dosenpa_id == Auth::user()->dosenpa->id)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->pengaduan->mahasiswa->nim }}</td>
                <td>{{ $item->pengaduan->mahasiswa->nama }}</td>
                <td>{{ $item->pengaduan->isi_pengaduan }}</td>
                <td>{{ $item->isi_tanggapan }}</td>
                <td>{{ $item->pengaduan->created_at }}</td>
                <td>
                    @if ($item->pengaduan->status == 'proses')
                    <span class="badge bg-warning text-dark">{{ $item->pengaduan->status }}</span>
                    @else
                    <span class="badge bg-success">{{ $item->pengaduan->status }}</span>
                    @endif
                </td>
                <td>
                    <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showtanggapan{{ $item->id }}"><span data-feather="eye"></span></button>
                </td>
            </tr>
            @endif
            @endif
            @endforeach

        </tbody>
    </table>
</div>

</div>

{{-- modal view --}}
@foreach($tanggapan as $item)
<div class="modal fade" id="showtanggapan{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Tanggapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body
                ">
                <div class="row">
                    <div class="col-md-5">
                        <div>
                            <label for="dokumen" class="form-label">Dokumen</label>
                            @if($item->pengaduan->dokumen)
                                @php
                                    $ext = pathinfo($item->pengaduan->dokumen, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                    <img src="{{ asset('storage/' . $item->pengaduan->dokumen) }}" alt="Dokumen" class="img-thumbnail" width="80">
                                @else
                                    <a href="{{ asset('storage/' . $item->pengaduan->dokumen) }}" target="_blank">Lihat / Download Dokumen</a>
                                @endif
                            @else
                                <span class="text-muted">Tidak ada dokumen.</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>NIM Mahasiswa:</strong> {{ $item->pengaduan->mahasiswa->nim }}</li>  
                            <li class="list-group-item"><strong>Nama Mahasiswa:</strong> {{ $item->pengaduan->mahasiswa->nama }}</li>
                            <li class="list-group-item"><strong>Isi Pengaduan:</strong> {{ $item->pengaduan->isi_pengaduan }}</li>
                            <li class="list-group-item"><strong>Tanggapan:</strong> {{ $item->isi_tanggapan }}</li>
                            <li class="list-group-item"><strong>Status:</strong> {{ $item->pengaduan->status }}</li>
                            <li class="list-group-item"><strong>Tanggal Masuk:</strong> {{ $item->pengaduan->created_at }}</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
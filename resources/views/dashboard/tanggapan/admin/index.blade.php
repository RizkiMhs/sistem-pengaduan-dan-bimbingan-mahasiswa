@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Riwayat Pengaduan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('dashboard.admin.export.pdf') }}" class="btn btn-outline-primary mb-3">Ekspor PDF</a>
            </div>
        </div>
    </div>

    {{-- ekspor pdf --}}

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- filter tanggal --}}
    <form action="/dashboard/tanggapanforadmin" method="get">
        <div class="row mb-3">
            <div class="col-md-5">
                <label for="start" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start" name="start">
            </div>
            <div class="col-md-5">
                <label for="end" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="end" name="end">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success mt-4">Filter</button>
            </div>
        </div>
    </form>

    {{-- pencarian --}}
    <form action="/dashboard/tanggapanforadmin" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari Pengaduan" name="cari">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
        </div>
    </form>


    <div class="table">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama Mahasiswa</th>
                    <th scope="col">Nama Dosen PA</th>
                    <th scope="col">Isi Pengaduan</th>
                    <th scope="col">Isi Tanggapan</th>
                    <th scope="col">Tanggal Masuk</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tanggapan as $item)
                @if ($item->pengaduan->status == 'selesai')
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->pengaduan->mahasiswa->nim }}</td>
                    <td>{{ $item->pengaduan->mahasiswa->nama }}</td>
                    <td>{{ $item->dosenpa->nama }}</td>
                    <td>{{ $item->pengaduan->isi_pengaduan }}</td>
                    <td>{{ $item->isi_tanggapan }}</td>
                    <td>{{ $item->pengaduan->created_at->format('d M Y') }}</td>
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
                @endforeach
    
            </tbody>
        </table>
    </div>

    {{-- pagination --}}

    
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
                            <img src="{{ asset('storage/' . $item->pengaduan->foto) }}" alt="{{ $item->pengaduan->isi_pengaduan }}" class="img-thumbnail" width="300">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {{ $tanggapan->links() }}      
    </div>
@endsection
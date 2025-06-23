@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Laporan Rekap Rating Dosen</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('dashboard.admin.export.rating') }}" class="btn btn-outline-primary mb-3">Ekspor PDF</a>
            </div>
        </div>
    </div>

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
        <form action="/dashboard/ratingdosen" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Pengaduan" name="cari">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
            </div>
        </form>

    <div class="table">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">NIPN Dosen</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Nilai</th>
                    {{-- <th scope="col">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($dosenpa as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        {{ $item->nama }}
                    </td>
                    <td>
                        {{ $item->nidn }}
                    </td>
                    <td>
                        @if ($item->rating->count())
                            @php
                                $hasil = $item->rating->avg('rating');
                                $bulat = round($hasil);
                            @endphp
                            @for ($i = 0; $i < $bulat; $i++)
                                <span data-feather="star" class="text-warning"></span>
                            @endfor
                        @else
                            Belum ada rating
                        @endif
                    </td>
                    <td>
                        @if ($item->rating->count())
                            @php
                                $hasil = $item->rating->avg('rating');
                                $bulat = round($hasil);
                            @endphp
                            @if ($bulat == 1)
                                Sangat Kurang
                            @elseif ($bulat == 2)
                                Kurang
                            @elseif ($bulat == 3)
                                Cukup
                            @elseif ($bulat == 4)
                                Baik
                            @elseif ($bulat == 5)
                                Sangat Baik
                            @endif
                        @else
                            Belum ada penilaian
                        @endif
                    </td>
                    {{-- <td>
                        @if ( $item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->isEmpty())
                            <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#add{{ $item->id }}"><span data-feather="edit"></span></button>
                        @else
                            <button class="badge bg-success border-0"><span data-feather="check"></span></button>
                        @endif
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection
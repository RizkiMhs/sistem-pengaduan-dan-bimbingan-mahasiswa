@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rating Dosen</h1>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="table">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">NIPN Dosen</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Aksi</th>
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
                        {{-- @if ($item->rating->count())
                            @php
                                $hasil = $item->rating->avg('rating');
                                $bulat = round($hasil);
                            @endphp
                            @for ($i = 0; $i < $bulat; $i++)
                                <span data-feather="star" class="text-warning"></span>
                            @endfor
                        @else
                            Belum ada rating
                        @endif --}}
                        {{-- berdasarkan id mahasiswa --}}
                        @if ($item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->count())
                            @php
                                // $hasil = $item->rating->avg('rating');
                                $rating = $item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->rating;
                            @endphp
                            @for ($i = 0; $i < $rating; $i++)
                                <span data-feather="star" class="text-warning"></span>
                            @endfor
                        @else
                            Belum ada rating
                        @endif
                    </td>
                    <td>
                        @if ($item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->count())
                            @php
                                
                                $bulat = $item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->rating;
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
                    <td>
                        @if ( $item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->isEmpty())
                            <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#add{{ $item->id }}"><span data-feather="edit"></span></button>
                        @else
                            <button class="badge bg-success border-0"><span data-feather="check"></span></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

{{-- add --}}
@foreach ($dosenpa as $item)
<div class="modal fade" id="add{{ $item->id }}" tabindex="-1" aria-labelledby="add{{ $item->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add{{ $item->id }}Label">Tambah Rating Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body
            ">
                <form action="/dashboard/rating" method="post">
                    @csrf
                    <input type="hidden" name="dosenpa_id" value="{{ $item->id }}">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Bagaimana proses Belajar dengan Beliu</label>
                        {{-- <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}"> --}}
                        <select class="form-select" aria-label="Default select example" name="pertanyaan_1">
                            <option selected>Pilih</option>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Sangat Kurang</option>
                        </select>
                        @error('pertanyaan_1')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Bagaimana penjelasan materi yang diberikan</label>
                        {{-- <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}"> --}}
                        <select class="form-select" aria-label="Default select example" name="pertanyaan_2">
                            <option selected>Pilih</option>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Sangat Kurang</option>
                        </select>
                        @error('pertanyaan_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Bagaimana penilaian terhadap tugas yang diberikan</label>
                        {{-- <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}"> --}}
                        <select class="form-select" aria-label="Default select example" name="pertanyaan_3">
                            <option selected>Pilih</option>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Sangat Kurang</option>
                        </select>
                        @error('pertanyaan_3')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Bagaimana penilaian terhadap ujian yang diberikan</label>
                        {{-- <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}"> --}}
                        <select class="form-select" aria-label="Default select example" name="pertanyaan_4">
                            <option selected>Pilih</option>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Sangat Kurang</option>
                        </select>
                        @error('pertanyaan_4')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Bagaimana penilaian terhadap kedisiplinan dosen</label>
                        {{-- <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}"> --}}
                        <select class="form-select" aria-label="Default select example" name="pertanyaan_5">
                            <option selected>Pilih</option>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Sangat Kurang</option>
                        </select>
                        @error('pertanyaan_5')
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
@endforeach
@endsection
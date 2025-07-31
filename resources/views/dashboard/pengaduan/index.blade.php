@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">pengaduan</h1>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tambah Pengaduan</h5>

                    <form method="post" action="/dashboard/pengaduan" enctype="multipart/form-data">
                        @csrf
                        <div class="card-tools">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <textarea value="{{ old('isi_pengaduan') }}" class="form-control @error('isi_pengaduan') is-invalid @enderror" name="isi_pengaduan" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"></textarea>
                                    <label for="floatingTextarea2">Isi Pengaduan disini</label>
                                    @error('isi_pengaduan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen (Gambar/PDF/Dokumen)</label>
                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen" name="dokumen" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                @error('dokumen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Riwayat Pengaduan</h5>

                    <div class="card-tools">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Isi Pengaduan</th>
                                        <th>Dokumen</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduan as $item)
                                    @if ($item->status == 'proses' || $item->status == 'tolak')
                                    @if ($item->mahasiswa->user_id == Auth::user()->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->isi_pengaduan }}</td>
                                        <td>
                                            @if($item->dokumen)
                                                @php
                                                    $ext = pathinfo($item->dokumen, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                                    <img src="{{ asset('storage/' . $item->dokumen) }}" alt="Dokumen" class="img-thumbnail" width="80">
                                                @else
                                                    <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank">Download / Lihat Dokumen</a>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'proses')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($item->status == 'tolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @else
                                            <span class="badge bg-success">Diterima</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="badge bg-success border-0" data-bs-toggle="modal" data-bs-target="#showpengaduan{{ $item->id }}"><span data-feather="eye"></span></button>
                                            @if ($item->status == 'tolak')
                                            <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#editmhs{{ $item->id }}"><span data-feather="edit"></span></button>
                                            @endif

                                            <form action="/dashboard/pengaduan/{{ $item->id }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                {{-- <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button> --}}
                                                <button class="badge bg-danger border-0" onclick="return confirm('Yakin ingin menghapus?')"><span data-feather="trash-2"></span></button>

                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal view --}}
    @foreach ($pengaduan as $item)
    <div class="modal fade" id="showpengaduan{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body
                ">
                    <p>{{ $item->isi_pengaduan }}</p>
                     @if($item->dokumen)
                                                @php
                                                    $ext = pathinfo($item->dokumen, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                                    <img src="{{ asset('storage/' . $item->dokumen) }}" alt="Dokumen" class="img-thumbnail" width="80">
                                                @else
                                                    <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank">Download / Lihat Dokumen</a>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- modal edit --}}

    @foreach ($pengaduan as $item)
    <div class="modal fade" id="editmhs{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/dashboard/pengaduan/{{ $item->id }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea value="{{ old('isi_pengaduan') }}" class="form-control @error('isi_pengaduan') is-invalid @enderror" name="isi_pengaduan" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px">{{ $item->isi_pengaduan }}</textarea>
                                <label for="floatingTextarea2">Isi Pengaduan disini</label>
                                @error('isi_pengaduan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    
@endsection
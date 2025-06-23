@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pendaftaran Bimbingan</h1>
</div>

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Bagian 1: Daftar Jadwal yang Tersedia --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Jadwal Bimbingan Tersedia</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Dosen PA</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Topik Umum</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Kuota</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalTersedia as $jadwal)
                        <tr>
                            <td>{{ $jadwal->dosenpa->nama }}</td>
                            <td>{{ $jadwal->kategoriBimbingan->nama_kategori }}</td>
                            <td>{{ $jadwal->topik_umum }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('d M Y, H:i') }}</td>
                            <td>{{ $jadwal->pendaftaranBimbingan->where('status_pengajuan', 'Diterima')->count() }} / {{ $jadwal->kuota_per_hari }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ajukanBimbinganModal" data-jadwal-id="{{ $jadwal->id }}" data-jadwal-topik="{{ $jadwal->topik_umum }}">
                                    Ajukan Bimbingan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Saat ini tidak ada jadwal bimbingan yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- Bagian 2: Riwayat Pengajuan Bimbingan Mahasiswa --}}
<div class="card">
    <div class="card-header">
        <h5>Riwayat Pengajuan Bimbingan Anda</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Topik Ajuan</th>
                        <th scope="col">Jadwal Dosen</th>
                        <th scope="col">Tanggal Pengajuan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pendaftaran->topik_mahasiswa }}</td>
                            <td>{{ $pendaftaran->jadwalBimbingan->dosenpa->nama }} - {{ \Carbon\Carbon::parse($pendaftaran->jadwalBimbingan->waktu_mulai)->format('d M Y, H:i') }}</td>
                            <td>{{ $pendaftaran->created_at->format('d M Y') }}</td>
                            <td>
                                @if($pendaftaran->status_pengajuan == 'Diterima')
                                    <span class="badge bg-success">{{ $pendaftaran->status_pengajuan }}</span>
                                @elseif($pendaftaran->status_pengajuan == 'Ditolak')
                                    <span class="badge bg-danger">{{ $pendaftaran->status_pengajuan }}</span>
                                @elseif($pendaftaran->status_pengajuan == 'Selesai')
                                    <span class="badge bg-secondary">{{ $pendaftaran->status_pengajuan }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $pendaftaran->status_pengajuan }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- PERUBAHAN: Tombol diubah menjadi link ke halaman detail --}}
                                <a href="{{ route('dashboard.mahasiswa.pendaftaran-bimbingan.show', $pendaftaran->id) }}" class="badge bg-info"><span data-feather="eye"></span></a>

                                @if ($pendaftaran->status_pengajuan == 'Diajukan')
                                    {{-- Menggunakan route helper untuk form action --}}
                                    <form action="{{ route('dashboard.mahasiswa.pendaftaran-bimbingan.destroy', $pendaftaran->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="badge bg-danger border-0" onclick="return confirm('Anda yakin ingin membatalkan pengajuan ini?')"><span data-feather="x-circle"></span></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum pernah mengajukan bimbingan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ajukan Bimbingan -->
<div class="modal fade" id="ajukanBimbinganModal" tabindex="-1" aria-labelledby="ajukanBimbinganModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajukanBimbinganModalLabel">Form Pengajuan Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Menggunakan route helper untuk form action --}}
                <form method="post" action="{{ route('dashboard.mahasiswa.pendaftaran-bimbingan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="jadwal_bimbingan_id" id="jadwal_id_input">
                    <p>Anda akan mendaftar untuk jadwal: <strong id="jadwal_topik_text"></strong></p>

                    <div class="mb-3">
                        <label for="topik_mahasiswa" class="form-label">Topik Spesifik Anda</label>
                        <input type="text" class="form-control @error('topik_mahasiswa') is-invalid @enderror" name="topik_mahasiswa" value="{{ old('topik_mahasiswa') }}" required>
                        @error('topik_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_mahasiswa" class="form-label">Deskripsi/Pertanyaan</label>
                        <textarea class="form-control @error('deskripsi_mahasiswa') is-invalid @enderror" name="deskripsi_mahasiswa" rows="4" required>{{ old('deskripsi_mahasiswa') }}</textarea>
                        @error('deskripsi_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="dokumen_mahasiswa" class="form-label">Dokumen Pendukung (Opsional)</label>
                        <input type="file" class="form-control @error('dokumen_mahasiswa') is-invalid @enderror" name="dokumen_mahasiswa">
                        @error('dokumen_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- PERUBAHAN: Semua modal detail dihapus karena sudah digantikan halaman show --}}

<script>
    const ajukanBimbinganModal = document.getElementById('ajukanBimbinganModal');
    if (ajukanBimbinganModal) {
        ajukanBimbinganModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const jadwalId = button.getAttribute('data-jadwal-id');
            const jadwalTopik = button.getAttribute('data-jadwal-topik');
            
            const modalJadwalIdInput = ajukanBimbinganModal.querySelector('#jadwal_id_input');
            const modalJadwalTopikText = ajukanBimbinganModal.querySelector('#jadwal_topik_text');

            modalJadwalIdInput.value = jadwalId;
            modalJadwalTopikText.textContent = jadwalTopik;
        });
    }
</script>

@endsection

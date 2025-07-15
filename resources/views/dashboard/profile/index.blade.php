@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Profil Saya</h1>
</div>

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Menampilkan error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@php
    $role = Auth::user()->role;
@endphp

<div class="row">
    @if ($role === 'mahasiswa' || $role === 'dosenpa')
    <div class="col-lg-4">
        {{-- Form Ganti Foto --}}
        <div class="card mb-4">
            <div class="card-header">Ganti Foto Profil</div>
            <div class="card-body text-center">
                 @php
                    $foto = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff';
                    if ($user->mahasiswa && $user->mahasiswa->foto) {
                        $foto = asset('storage/' . $user->mahasiswa->foto);
                    } elseif ($user->dosenpa && $user->dosenpa->foto) {
                        $foto = asset('storage/' . $user->dosenpa->foto);
                    }
                @endphp
                <img src="{{ $foto }}" class="img-thumbnail mb-3" alt="Foto Profil" width="300" height="300" style="object-fit: cover;">
                
                <form action="{{ route('dashboard.profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control form-control-sm" id="foto" name="foto" type="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Upload Foto Baru</button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-8">
        {{-- Form Ganti Password --}}
        <div class="card">
            <div class="card-header">Ganti Password</div>
            <div class="card-body">
                <form action="{{ route('dashboard.profile.password.update') }}" method="POST">
                    @method('put')
                    @csrf
                     <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

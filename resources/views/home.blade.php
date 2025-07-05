@extends('layouts.main')

@section('container')
<style>
    /* Menambahkan sedikit style untuk background */
    body {
        background-color: #f8f9fa;
    }
</style>

{{-- Menggunakan layout 2 kolom dari Bootstrap --}}
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    
    {{-- Menampilkan pesan sukses atau error di atas --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="row align-items-center g-lg-5 py-5">
        {{-- Kolom Kiri: Judul dan Deskripsi --}}
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">CampusCare</h1>
            <p class="col-lg-10 fs-4">Layanan terintegrasi untuk pengaduan dan bimbingan mahasiswa. Sampaikan aspirasi dan keluhan Anda, atau atur jadwal bimbingan dengan mudah bersama Dosen Pembimbing Akademik Anda.</p>
        </div>

        {{-- Kolom Kanan: Form Login --}}
        <div class="col-md-10 mx-auto col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span data-feather="send" class="text-primary" style="width: 48px; height: 48px;"></span>
                        <h2 class="h3 fw-bold mt-2">Login Akun</h2>
                        <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                    </div>

                    <form action="/login" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                            <label for="email">Alamat Email</label>
                            
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <button class="w-100 btn btn-lg btn-primary" type="submit">Masuk</button>
                        <hr class="my-4">
                        <small class="text-muted d-block text-center">Layanan Pengaduan & Bimbingan Mahasiswa.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

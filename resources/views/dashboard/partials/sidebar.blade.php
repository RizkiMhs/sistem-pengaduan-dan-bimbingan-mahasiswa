<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    
    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none px-3">
      <span data-feather="box" class="me-2"></span>
      <span class="fs-4">CampusCare</span>
    </a>
    <hr>

    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
    </ul>

    @can('admin')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Master Data</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/mahasiswa-admin*') ? 'active' : '' }}" href="/dashboard/mahasiswa-admin">
          <span data-feather="users" class="align-text-bottom"></span>
          Mahasiswa
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/dosen-pa*') ? 'active' : '' }}" href="/dashboard/dosen-pa">
          <span data-feather="user-plus" class="align-text-bottom"></span>
          Dosen
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/fakultas*') ? 'active' : '' }}" href="/dashboard/fakultas">
          <span data-feather="layers" class="align-text-bottom"></span>
          Fakultas
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/prodi*') ? 'active' : '' }}" href="/dashboard/prodi">
          <span data-feather="grid" class="align-text-bottom"></span>
          Program Studi
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/kategori-bimbingan*') ? 'active' : '' }}" href="/dashboard/kategori-bimbingan">
          <span data-feather="tag" class="align-text-bottom"></span>
          Kategori Bimbingan
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Laporan</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/tanggapan-admin*') ? 'active' : '' }}" href="/dashboard/tanggapan-admin">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Pengaduan
        </a>
      </li>
    </ul>
    @endcan

    {{-- Menu untuk Dosen PA --}}
    @can('dosen_pa')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
        <span>Aktivitas</span>
    </h6>
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/pengajuan-masuk*')? 'active' : '' }}" href="/dashboard/pengajuan-masuk">
                <span data-feather="inbox" class="align-text-bottom"></span>
                Pengajuan Bimbingan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/jadwal-bimbingan*')? 'active' : '' }}" href="/dashboard/jadwal-bimbingan">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Jadwal Bimbingan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/pengaduan-dosen*')? 'active' : '' }}" href="/dashboard/pengaduan-dosen">
                <span data-feather="alert-circle" class="align-text-bottom"></span>
                Daftar Pengaduan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/tanggapan*')? 'active' : '' }}" href="/dashboard/tanggapan">
                <span data-feather="archive" class="align-text-bottom"></span>
                Riwayat Pengaduan
            </a>
        </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
        <span>Master</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/mahasiswa*')? 'active' : '' }}" href="/dashboard/mahasiswa">
          <span data-feather="users" class="align-text-bottom"></span>
          Mahasiswa Bimbingan
        </a>
      </li>
    </ul>
    @endcan
    
    {{-- Menu untuk Mahasiswa --}}
    @can('mahasiswa')
     <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
        <span>Aktivitas</span>
    </h6>
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/pendaftaran-bimbingan*')? 'active' : '' }}" href="/dashboard/pendaftaran-bimbingan">
              <span data-feather="edit-3" class="align-text-bottom"></span>
              Pendaftaran Bimbingan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/pengaduan*')? 'active' : '' }}" href="/dashboard/pengaduan">
              <span data-feather="send" class="align-text-bottom"></span>
              Buat Pengaduan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/tanggapan-mahasiswa*')? 'active' : '' }}" href="/dashboard/tanggapan-mahasiswa">
              <span data-feather="inbox" class="align-text-bottom"></span>
              Tanggapan Dosen
            </a>
        </li>
    </ul>

    @endcan

    <hr class="my-3">
    <div class="dropdown px-3">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            @if (auth()->check() && auth()->user()->mahasiswa && auth()->user()->mahasiswa->foto)
    
    {{-- Jika ada, tampilkan foto dari storage --}}
    <img src="{{ asset('storage/' . auth()->user()->mahasiswa->foto) }}" alt="Foto Profil" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">

@else

    {{-- Jika tidak ada, tampilkan gambar placeholder default --}}
    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=random&color=fff" alt="Foto Default" width="32" height="32" class="rounded-circle me-2">

@endif
            <strong>{{ auth()->user()->name }}</strong> </a>
        <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="{{ route('dashboard.profile.index') }}">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="/logout" method="post"> @csrf
                    <button type="submit" class="dropdown-item">Sign out</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1"></div>
  </div>
</nav>
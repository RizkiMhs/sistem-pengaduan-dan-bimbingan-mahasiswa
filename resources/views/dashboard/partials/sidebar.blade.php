<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">

  <div class="position-sticky pt-3">
    {{-- <p>{{ auth()->user()->role }}</p> --}}
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard')? 'active' : '' }}" aria-current="page" href="/dashboard">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>
    </ul>

    @can('admin')

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Master</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/mahasiswa-admin')? 'active' : '' }}  " href="/dashboard/mahasiswa-admin">
          <span data-feather="users"></span>
          Mahasiswa
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard/dosen-pa')? 'active' : '' }} " href="/dashboard/dosen-pa">
          <span data-feather="user-plus"></span>
          Dosen PA
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard/kelas')? 'active' : '' }} " href="/dashboard/kelas">
          <span data-feather="command"></span>
          Kelas
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard/fakultas')? 'active' : '' }} " href="/dashboard/fakultas">
          <span data-feather="command"></span>
          Fakultas
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard/prodi')? 'active' : '' }} " href="/dashboard/prodi">
          <span data-feather="command"></span>
          Program Studi
        </a>
      </li>
      {{-- untuk kategori bimbingan --}}

      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/kategori-bimbingan')? 'active' : '' }} " href="/dashboard/kategori-bimbingan">
          <span data-feather="command"></span>
          Kategori Bimbingan
        </a> 
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Laporan</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/tanggapan-admin')? 'active' : '' }} " href="/dashboard/tanggapan-admin">
          <span data-feather="file-text"></span>
          Pengaduan
        </a>
      </li>
    </ul>
   
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/rating-dosen')? 'active' : '' }} " href="/dashboard/rating-dosen">
          <span data-feather="pie-chart"></span>
          Rekap Rating Dosen
        </a>
      </li>
    </ul>
    

    @endcan

    @can('dosen_pa')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Pengaduan</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link  {{ Request::is('dashboard/pengaduan-dosen')? 'active' : '' }}  " href="/dashboard/pengaduan-dosen">
          <span data-feather="slack"></span>
          Daftar Pengaduan
        </a>
      </li>
    </ul>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/tanggapan')? 'active' : '' }}  " href="/dashboard/tanggapan">
          <span data-feather="archive"></span>
          Riwayat Pengaduan
        </a>
      </li>
    </ul>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/jadwal-bimbingan')? 'active' : '' }}  " href="/dashboard/jadwal-bimbingan">
          <span data-feather="calendar"></span>
          Jadwal Bimbingan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/pengajuan-masuk')? 'active' : '' }}" href="/dashboard/pengajuan-masuk">
            <span data-feather="file-text"></span>
            Pengajuan Bimbingan
        </a>
      </li>
    </ul>
    




    @endcan

    @can('dosen_pa')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Master</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/mahasiswa')? 'active' : '' }}  " href="/dashboard/mahasiswa">
          <span data-feather="users"></span>
          Mahasiswa
        </a>
      </li>
    </ul>
    @endcan

    @can('mahasiswa')
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/pengaduan')? 'active' : '' }} " href="/dashboard/pengaduan">
          <span data-feather="slack"></span>
          Pengaduan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/tanggapan-mahasiswa')? 'active' : '' }}  " href="/dashboard/tanggapan-mahasiswa">
          <span data-feather="slack"></span>
          Tanggapan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/pendaftaran-bimbingan')? 'active' : '' }}  " href="/dashboard/pendaftaran-bimbingan">
          <span data-feather="calendar"></span>
          Pendaftaran Bimbingan
        </a>
      </li>
    </ul>
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Dosen</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/rating')? 'active' : '' }}  " href="/dashboard/rating">
          <span data-feather="users"></span>
          Rating Dosen
        </a>
      </li>
    </ul>

    @endcan





  </div>
</nav>

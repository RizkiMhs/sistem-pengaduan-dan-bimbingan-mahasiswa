<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\LoginController;
// use App\Models\Dosenpa;
// use App\Models\Mahasiswa;
// use App\Http\Controllers\MahasiswaController;
// use App\Http\Controllers\DosenpaController;
// use App\Http\Controllers\PengaduanController;
// use App\Http\Controllers\MhsForAdminController;
// use App\Http\Controllers\PengaduanForDosenController;
// use App\Http\Controllers\TanggapanController;
// use App\Http\Controllers\TanggapanForMhs;
// use App\Http\Controllers\TanggapanForAdminController;
// use App\Http\Controllers\TingkatController;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\PdfController;
// use App\Http\Controllers\RatingController;
// use App\Http\Controllers\RatingForAdminController;
// use App\Models\Pengaduan;
// use App\Models\Tanggapan;


// Route::get('/', function () {
//     return view('home');
// });

// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout']);

// Route::get('/dashboard', function () {
//     return view('dashboard.index', [
//         'title' => 'Dashboard',
//         'active' => 'dashboard',
//         'totalDosenpa' => Dosenpa::all()->count(),
//         'totalMahasiswa' => Mahasiswa::all()->count(),
//         'totalPenganduan' => Pengaduan::all()->count(),
//         'totalPengadaanProses' => Pengaduan::where('status', 'proses')->count(),
//         'totalTanggapan' => Tanggapan::all()->count(),

//     ]);
// })->middleware('auth');


// Route::group(['middleware' => 'admin'], function () {



//     Route::resource('/dashboard/dosenpa', DosenpaController::class);
//     Route::resource('/dashboard/tanggapanforadmin', TanggapanForAdminController::class);
//     Route::get('/dashboard/exportpdf', [PdfController::class, 'exportpdf']);
//     Route::get('/dashboard/exportrating', [PdfController::class, 'exportrating']);
//     Route::get('/dashboard/exportratingall', [PdfController::class, 'exportratingall']);


//     Route::resource('/dashboard/mahasiswaforadmin', MhsForAdminController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
//     Route::resource('/dashboard/kelas', TingkatController::class);
//     Route::resource('/dashboard/ratingdosen', RatingForAdminController::class);
//     Route::get('/dashboard/ratingdosenoll', [RatingForAdminController::class, 'ratingdosenoll']);

// });

// Route::group(['middleware' => 'dosenpa'], function () {


//     Route::resource('/dashboard/mahasiswa', MahasiswaController::class);
// });

// Route::resource('/dashboard/pengaduan', PengaduanController::class)->middleware('mahasiswa');
// Route::resource('/dashboard/pengaduanForDosen', PengaduanForDosenController::class)->middleware('dosenpa');
// Route::resource('/dashboard/riwayatPengaduan', PengaduanForDosenController::class)->middleware('dosenpa');
// Route::resource('/dashboard/tanggapan', TanggapanController::class)->middleware('dosenpa');
// Route::resource('/dashboard/tanggapanForMhs ', TanggapanForMhs::class)->middleware('mahasiswa');
// Route::resource('/dashboard/rating', RatingController::class)->middleware('mahasiswa');





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranBimbinganController;
use App\Http\Controllers\CatatanBimbinganController;

// --- Controller Imports ---
// Grouped for better readability
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;

// Admin Controllers
use App\Http\Controllers\DosenpaController;
use App\Http\Controllers\MhsForAdminController;
use App\Http\Controllers\RatingForAdminController;
use App\Http\Controllers\TanggapanForAdminController;
use App\Http\Controllers\TingkatController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KategoriBimbinganController;



// DosenPA Controllers
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengaduanForDosenController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\JadwalBimbinganController;

// Mahasiswa Controllers
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TanggapanForMhs;
use App\Models\Faculty;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda mendaftarkan web routes untuk aplikasi Anda.
|
*/

// Halaman utama (Publik)
Route::get('/', function () {
    return view('home');
})->name('home');

// Autentikasi
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')
    ->middleware('auth')
    ->name('dashboard.')
    ->group(function () {

        Route::get('/', DashboardController::class)->name('index');

        /*
        |----------------------------------
        | Grup Route untuk ADMIN
        |----------------------------------
        */
        Route::middleware('admin')
            ->name('admin.')
            ->group(function () {


                Route::get('/dosen-pa', [DosenpaController::class, 'index'])->name('dosen-pa.index');
                Route::post('/dosen-pa', [DosenpaController::class, 'store'])->name('dosen-pa.store');
                Route::put('/dosen-pa/{dosenpa}', [DosenpaController::class, 'update'])->name('dosen-pa.update');
                Route::delete('/dosen-pa/{dosenpa}', [DosenpaController::class, 'destroy'])->name('dosen-pa.destroy');

                Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
                Route::post('/fakultas', [FakultasController::class, 'store'])->name('fakultas.store');
                Route::put('/fakultas/{fakultas}', [FakultasController::class, 'update'])->name('fakultas.update');
                Route::delete('/fakultas/{fakultas}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');

                Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
                Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
                Route::put('/prodi/{prodi}', [ProdiController::class, 'update'])->name('prodi.update');
                Route::delete('/prodi/{prodi}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

                Route::get('kategori-bimbingan', [KategoriBimbinganController::class, 'index'])->name('kategori-bimbingan.index');
                Route::post('kategori-bimbingan', [KategoriBimbinganController::class, 'store'])->name('kategori-bimbingan.store');
                Route::put('kategori-bimbingan/{kategoriBimbingan}', [KategoriBimbinganController::class, 'update'])->name('kategori-bimbingan.update');
                Route::delete('kategori-bimbingan/{kategoriBimbingan}', [KategoriBimbinganController::class, 'destroy'])->name('kategori-bimbingan.destroy');

                Route::get('mahasiswa-admin', [MhsForAdminController::class, 'index'])->name('mahasiswa.index');
                Route::post('mahasiswa-admin', [MhsForAdminController::class, 'store'])->name('mahasiswa.store');
                Route::put('mahasiswa-admin/{mahasiswa}', [MhsForAdminController::class, 'update'])->name('mahasiswa.update');
                Route::delete('mahasiswa-admin/{mahasiswa}', [MhsForAdminController::class, 'destroy'])->name('mahasiswa.destroy');


                Route::resource('kelas', TingkatController::class);
                Route::resource('rating-dosen', RatingForAdminController::class);
                Route::get('rating-dosen-semua', [RatingForAdminController::class, 'ratingdosenoll'])->name('rating-dosen.all');


                Route::prefix('export')->name('export.')->group(function () {

                    Route::get('laporan', [PdfController::class, 'exportpdf'])->name('pdf');

                    Route::get('rating', [PdfController::class, 'exportrating'])->name('rating');
                    Route::get('rating/semua', [PdfController::class, 'exportratingall'])->name('rating.all');
                });
            });

        /*
        |----------------------------------
        | Grup Route untuk DOSEN PA
        |----------------------------------
        */
        Route::middleware('dosenpa')
            ->name('dosen.')
            ->group(function () {

                Route::resource('mahasiswa', MahasiswaController::class);
                Route::resource('pengaduan-dosen', PengaduanForDosenController::class);
                Route::resource('tanggapan', TanggapanController::class);

                Route::get('jadwal-bimbingan', [JadwalBimbinganController::class, 'index'])->name('jadwal-bimbingan.index');
                Route::post('jadwal-bimbingan', [JadwalBimbinganController::class, 'store'])->name('jadwal-bimbingan.store');
                Route::put('jadwal-bimbingan/{jadwalBimbingan}', [JadwalBimbinganController::class, 'update'])->name('jadwal-bimbingan.update');
                Route::delete('jadwal-bimbingan/{jadwalBimbingan}', [JadwalBimbinganController::class, 'destroy'])->name('jadwal-bimbingan.destroy');

                // PERBAIKAN NAMA RUTE: Nama rute ini sekarang unik (dashboard.dosen.pendaftaran-bimbingan.index)
                Route::get('pengajuan-masuk', [PendaftaranBimbinganController::class, 'index'])->name('pendaftaran-bimbingan.index');
                Route::get('pengajuan-masuk/{pendaftaranBimbingan}', [PendaftaranBimbinganController::class, 'show'])->name('pengajuan-masuk.show');
                Route::put('pengajuan-masuk/{pendaftaranBimbingan}', [PendaftaranBimbinganController::class, 'update'])->name('pengajuan-masuk.update');
            });

        /*
        |----------------------------------
        | Grup Route untuk MAHASISWA
        |----------------------------------
        */
        Route::middleware('mahasiswa')
            ->name('mahasiswa.')
            ->group(function () {

                Route::resource('pengaduan', PengaduanController::class);
                Route::resource('rating', RatingController::class);

                Route::get('tanggapan-mahasiswa', [TanggapanForMhs::class, 'index'])->name('tanggapan.index');

                // PERBAIKAN NAMA RUTE: Nama rute ini sekarang unik (dashboard.mahasiswa.pendaftaran-bimbingan.index)
                Route::get('pendaftaran-bimbingan', [PendaftaranBimbinganController::class, 'index'])->name('pendaftaran-bimbingan.index');
                Route::get('pendaftaran-bimbingan/{pendaftaranBimbingan}', [PendaftaranBimbinganController::class, 'show'])->name('pendaftaran-bimbingan.show');
                Route::post('pendaftaran-bimbingan', [PendaftaranBimbinganController::class, 'store'])->name('pendaftaran-bimbingan.store');
                Route::delete('pendaftaran-bimbingan/{pendaftaranBimbingan}', [PendaftaranBimbinganController::class, 'destroy'])->name('pendaftaran-bimbingan.destroy');
            });

        Route::prefix('catatan-bimbingan')
            ->name('catatan-bimbingan.')
            ->group(function () {
                // Rute untuk menampilkan detail catatan bimbingan (jika diperlukan halaman khusus)
                Route::get('/{catatanBimbingan}', [CatatanBimbinganController::class, 'show'])->name('show');
                Route::post('/', [CatatanBimbinganController::class, 'store'])->name('store');
                Route::delete('/{catatanBimbingan}', [CatatanBimbinganController::class, 'destroy'])->name('destroy');
            });

        // Rute untuk Profil
        // Rute untuk Profil
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        // Rute spesifik untuk update foto (menggunakan POST untuk file upload)
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
        // Rute spesifik untuk update password
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

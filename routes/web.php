<?php

use App\Http\Controllers\ProfilAcc;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\DataGuru;
use App\Http\Livewire\Admin\DataJurusan;
use App\Http\Livewire\Admin\DataKelas;
use App\Http\Livewire\Admin\DataMapel;
use App\Http\Livewire\Admin\DataSiswa;
use App\Http\Livewire\Admin\DetailGuru;
use App\Http\Livewire\Admin\DetailMapel;
use App\Http\Livewire\Admin\DetailSiswa;
use App\Http\Livewire\Guru\Dashboard as GuruDashboard;
use App\Http\Livewire\Guru\ListPresensi;
use App\Http\Livewire\Guru\PresensiGuru;
use App\Http\Livewire\ProfilUser;
use App\Http\Livewire\ShowPosts;
use App\Http\Livewire\Siswa\DashboardSiswa;
use App\Http\Livewire\Siswa\ListPresensi as SiswaListPresensi;
use App\Http\Livewire\Siswa\PresensiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/show', ShowPosts::class);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    if (Auth::user()) {
        if (Auth::user()->hasRole('admin')) {
            // dd('admin');
            // echo 'admin';
            return redirect(route('dashboardAdm'));
        } else if (Auth::user()->hasRole('guru')) {
            // dd('guru');
            return redirect(route('dashboardGuru'));
            # return view('guru/dashboardGuru');
            // return redirect(route('login'));
        } else if (Auth::user()->hasRole('siswa')) {
            return redirect(route('dashboardSiswa'));
            # return view('siswa/dashboardSis');
            // return redirect(route('login'));
        } else {
            return redirect(route('login'));
        }
    } else {
        return view('guest-dashboard');
        // return redirect(route('login'));
    }
});

Route::get('/download/{file_name}', function ($file_name) {
    // dd($file_name);
    return response()->download(public_path('lms/doc_lms/' . $file_name));
})->name('downloadFile');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)->name('dashboardAdm');
    Route::get('/guru/dashboard', GuruDashboard::class)->name('dashboardGuru');
    Route::get('/siswa/dashboard', DashboardSiswa::class)->name('dashboardSiswa');
    // Route::get('/admin/profil', function () {
    //     return view('admin/profile');
    // });
    // Route::get('/admin/tambahGuru', [AdminController::class, 'tambahGuru'])->name('tambahGuru');
});

Route::middleware(['auth'])->group(function () {

    // ----------- ADMIN START --------------------------------
    // GURU Section
    Route::get('/admin/data-guru', DataGuru::class)->name('dataGuru');
    Route::get('/admin/profil-guru/{id}', DetailGuru::class)->name('profilGID');
    // SISWA Section
    Route::get('/admin/data-siswa', DataSiswa::class)->name('dataSiswa');
    Route::get('/admin/profil-siswa/{id}', DetailSiswa::class)->name('profilSID');
    // JURUSAN Section
    Route::get('/admin/data-jurusan', DataJurusan::class)->name('dataJurusan');
    // KELAS Section
    Route::get('/admin/data-kelas', DataKelas::class)->name('dataKelas');
    // MAPEL Section
    Route::get('/admin/data-mapel', DataMapel::class)->name('dataMapel');
    Route::get('/admin/data-detail-mapel', DetailMapel::class)->name('detailMapel');
    // ----------- ADMIN END --------------------------------


    // ----------- GURU START --------------------------------
    Route::get('/guru/tambah-presensi/{nav_dmid}', PresensiGuru::class)->name('presensiGuru');
    Route::get('/guru/detail-presensi/{id_pres}', ListPresensi::class)->name('listPresensiGuru');
    // ----------- GURU END --------------------------------

    // ----------- SISWA START --------------------------------
    Route::get('/siswa/list-presensi', SiswaListPresensi::class)->name('listPresensiSiswa');
    Route::get('/siswa/presensi/{id_pres}', PresensiSiswa::class)->name('presensiSiswa');
    // ----------- SISWA END --------------------------------

    // ----------- PROFIL START --------------------------------
    Route::get('/admin/profil/{id}', ProfilUser::class)->name('profilAcc');
    Route::post('crop', [ProfilAcc::class, 'crop'])->name('pcrop');
    // ----------- PROFIL END --------------------------------
});

require __DIR__ . '/auth.php';
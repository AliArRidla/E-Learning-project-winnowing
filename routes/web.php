<?php

use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfilAcc;
use App\Http\Controllers\TugasController;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\DataGuru;
use App\Http\Livewire\Admin\DataJurusan;
use App\Http\Livewire\Admin\DataKelas;
use App\Http\Livewire\Admin\DataMapel;
use App\Http\Livewire\Admin\DataSiswa;
use App\Http\Livewire\Admin\DetailGuru;
use App\Http\Livewire\Admin\DetailMapel;
use App\Http\Livewire\Admin\DetailSiswa;
use App\Http\Livewire\Guru\CustomSoal;
use App\Http\Livewire\Guru\DaftarNilai;
use App\Http\Livewire\Guru\Dashboard as GuruDashboard;
use App\Http\Livewire\Guru\DataMateri;
use App\Http\Livewire\Guru\DataMateriEdit;
use App\Http\Livewire\Guru\DataMateriTambah;
use App\Http\Livewire\Guru\DataTugas;
use App\Http\Livewire\Guru\DataTugasTambah;
use App\Http\Livewire\Guru\DataTugasEdit;
use App\Http\Livewire\Guru\DetailMateri;
use App\Http\Livewire\Guru\DetailPresensi;
use App\Http\Livewire\Guru\DetailTugas;
use App\Http\Livewire\Guru\EditSoal;
use App\Http\Livewire\Guru\EditUlangan;
use App\Http\Livewire\Guru\HasilUjian;
use App\Http\Livewire\Guru\ListPresensi;
use App\Http\Livewire\Guru\ListSoal;
use App\Http\Livewire\Guru\PengumpulanTugas as GuruPengumpulanTugas;
use App\Http\Livewire\Guru\PresensiGuru;
use App\Http\Livewire\Guru\SoalUlangan;
use App\Http\Livewire\Guru\SoalUlanganEssay;
use App\Http\Livewire\Guru\SoalUlangan2;
use App\Http\Livewire\Guru\TambahUlangan;
use App\Http\Livewire\ProfilUser;
use App\Http\Livewire\ShowPosts;
use App\Http\Livewire\Siswa\DashboardSiswa;
use App\Http\Livewire\Siswa\DataMateri as SiswaDataMateri;
use App\Http\Livewire\Siswa\DataTugas as SiswaDataTugas;
use App\Http\Livewire\Siswa\DetDataMateri;
use App\Http\Livewire\Siswa\KerjakanUlangan;
use App\Http\Livewire\Siswa\ListPresensi as SiswaListPresensi;
use App\Http\Livewire\Siswa\ListUlangan;
use App\Http\Livewire\Siswa\PengumpulanTugas;
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
    return response()->download($_SERVER['DOCUMENT_ROOT'].'/lms/doc_lms/' . $file_name);
})->name('downloadFile');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)->name('dashboardAdm');
    Route::get('/guru/dashboard', GuruDashboard::class)->name('dashboardGuru');
    Route::get('/siswa/dashboard', DashboardSiswa::class)->name('dashboardSiswa');
});

Route::middleware(['auth', 'verified'])->group(function () {

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
});

Route::middleware(['auth'])->group(function () {
    // ----------- GURU START --------------------------------
    // PRESENSI
    Route::get('/guru/presensi/{nav_dmid}', PresensiGuru::class)->name('presensiGuru');
    Route::get('/guru/daftar-presensi/{nav_dmid}/{id_pres}', DetailPresensi::class)->name('daftarPresensiGuru');
    Route::get('/guru/detail-presensi/{nav_dmid}/{id_pres}/{tgl}', ListPresensi::class)->name('listPresensiGuru');
    
    // ULANGAN
    Route::get('/guru/ulangan/{nav_dmid}', TambahUlangan::class)->name('ulanganGuru');
    Route::get('/guru/soal-ulangan/{nav_dmid}/{id_ul}', SoalUlangan::class)->name('soalGuru');
    Route::get('/guru/soal-ulangan-essay/{nav_dmid}/{id_ul}', SoalUlanganEssay::class)->name('soalGuruEssay');
    Route::get('/guru/list-soal-ulangan/{nav_dmid}/{id_ul}', ListSoal::class)->name('listSoalGuru');
    Route::get('/guru/edit-soal-ulangan/{nav_dmid}/{id_ul}/{noc}/{ids}', EditSoal::class)->name('editSoalGuru');
    Route::get('/guru/list-hasil-ulangan/{nav_dmid}/{id_ul}', HasilUjian::class)->name('listHasilGuru');
   
    // MATERI
    Route::get('/guru/list-materi/{nav_dmid}', DataMateri::class)->name('dataMateri');
    Route::get('/guru/detail-materi/{nav_dmid}/{id_mat}', DetailMateri::class)->name('detailMateri');
    Route::get('/guru/data-materi-tambah/{nav_dmid}', DataMateriTambah::class)->name('dataMateriTambah');
    Route::get('/guru/data-materi-edit/{nav_dmid}/{id_mat}', DataMateriEdit::class)->name('dataMateriEdit');
    Route::get('/download-file-materi/{foldname}', function ($foldname) {
        return response()->download($_SERVER['DOCUMENT_ROOT'].'/storage/public/file-materi/' . $foldname);
    })->name('downloadFileMatLama');
    
    // TUGAS
    Route::get('/guru/data-tugas/{nav_dmid}', DataTugas::class)->name('dataTugas');
    Route::get('/guru/detail-tugas/{nav_dmid}/{id_tgs}', DetailTugas::class)->name('detailTugas');
    Route::get('/guru/data-tugas-tambah/{nav_dmid}', DataTugasTambah::class)->name('dataTugasTambah');
    Route::get('/guru/data-tugas-edit/{nav_dmid}/{idTgs}', DataTugasEdit::class)->name('dataTugasEdit');
    Route::get('/guru/data-pengumpulan-tugas/{nav_dmid}/{id_tgs}', GuruPengumpulanTugas::class)->name('dataPengumpulanTugasGuru');
    Route::get('/download-file-tugas/{oldtugas}', function ($oldtugas) {
        return response()->download($_SERVER['DOCUMENT_ROOT'].'/storage/public/file_tugas/' . $oldtugas);
    })->name('downloadOldTugas');
    // DAFTAR NILAI
    Route::get('/guru/daftar-nilai-guru/{nav_dmid}', DaftarNilai::class)->name('daftarNilaiGuru');
    // ----------- GURU END --------------------------------

    // ----------- SISWA START --------------------------------
    // PRESENSI
    Route::get('/siswa/list-presensi', SiswaListPresensi::class)->name('listPresensiSiswa');
    Route::get('/siswa/presensi/{id_pres}', PresensiSiswa::class)->name('presensiSiswa');
    // ULANGAN
    Route::get('/siswa/ulangan/{nav_dmid}', ListUlangan::class)->name('ulanganSiswa');
    Route::get('/siswa/kerjakan-ulangan/{nav_dmid}/{id_ul}', KerjakanUlangan::class)->name('kerjakanUlSiswa');
    // MATERI TUGAS
    Route::get('/siswa/data-materi/{nav_dmid}', SiswaDataMateri::class)->name('dataMateriSiswa');
    Route::get('/siswa/det-data-materi/{nav_dmid}/{id_mats}', DetDataMateri::class)->name('materiSiswa');
    Route::get('/siswa/pengumpulan-tugas/{nav_dmid}/{id_tgs}', PengumpulanTugas::class)->name('tugasSiswa');
    Route::get('/download-file-tugas-siswa/{oldtugas}', function ($oldtugas) {
        return response()->download($_SERVER['DOCUMENT_ROOT'].'/storage/public/tugas_siswa/');
    })->name('downloadOldTugasSiswa');
    // ----------- SISWA END --------------------------------

    // ----------- PROFIL START --------------------------------
    Route::get('/admin/profil', ProfilUser::class)->name('profilAcc');
    Route::post('crop', [ProfilAcc::class, 'crop'])->name('pcrop');
    // ----------- PROFIL END --------------------------------


    // ----------- MATERI SISWA LIVEWIRE START --------------------------------
    Route::get('/download-file-matGuru/{filemat}', function ($filemat) {
        // dd($file_name);
        return response()->download($_SERVER['DOCUMENT_ROOT'].'/storage/public/file-materi/' . $filemat);
    })->name('downloadMatGuru');
    // ----------- MATERI SISWA END --------------------------------

    // ----------- TUGAS GURU LIVEWIRE START --------------------------------
    Route::post('/store/{nav_dmid}', [TugasController::class, 'store'])->name('tugasTambah');
    Route::patch('/guru/data-tugas-edit/{nav_dmid}/{idTgs}', [TugasController::class, 'update'])->name('tugasUpdate');
    // ----------- TUGAS GURU END --------------------------------

    // ----------- TUGAS SISWA LIVEWIRE START --------------------------------
    Route::get('/siswa/data-tugas/{nav_dmid}', SiswaDataTugas::class)->name('dataTugasSiswa');

    // ----------- TUGAS SISWA END --------------------------------

});

require __DIR__ . '/auth.php';

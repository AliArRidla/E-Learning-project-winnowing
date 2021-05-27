<?php

namespace App\Http\Livewire\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DataSiswa extends Component
{
    public $ids, $name, $email, $password, $id_kelas, $nis;

    public function addSiswa()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'id_kelas' => 'required',
            'nis' => 'required|unique:siswas,nis',
        ]);

        // dd($this->name, $this->email, $this->password, $this->id_kelas, $this->nis);

        $userS = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $userS->attachRole('siswa');

        $siswa = Siswa::create([
            'user_id' => $userS->id,
            'id_kelas' => $this->id_kelas,
            'nis' => $this->nis,
        ]);

        if ($siswa) {
            return redirect(route('dataSiswa'));
            session()->flash('msg', 'Data berhasil ditambah');
        } else {
            return redirect(route('dataSiswa'));
            session()->flash('msg', 'Data GAGAL ditambah');
        }
    }

    public function delSiswa($id, $name)
    {
        $this->ids = $id;
        $this->name = $name;
        $delSiswa = Siswa::find($id);
        // dd($delSiswa);
        $delSiswa->delete();
        return redirect(route('dataSiswa'));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    public function getAllSiswa()
    {
        $siswa = DB::select('select s.id, s.user_id, s.nis, u.name, u.email, k.nama_kelas
        from siswas as s
        join kelas as k on k.id = s.id_kelas
        join users as u on u.id = s.user_id
        join role_user as ru on ru.user_id = u.id 
        join roles AS r on r.id = ru.role_id
        where r.name = ?', ['siswa']);
        return $siswa;
    }

    public function getAllKelas()
    {
        $kelas = DB::select('select * from kelas');
        return $kelas;
    }

    public function reload()
    {
        return redirect(route('dataSiswa'));
    }

    public function cekJurusan()
    {
        $cek = DB::table('jurusans')->count();
        return $cek;
    }

    public function countKelas()
    {
        $jmlKelas = DB::table('kelas')->count();
        // dd($jmlGuru);
        return $jmlKelas;
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        } else if (Auth::user()->hasRole('admin')) {
            $data = DB::select('select a.id as rid, a.user_id as uid, a.foto
            from admins as a
            join users as u on u.id = a.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        // else if (Auth::user()->hasRole('siswa')) {
        //     // $data = DB::select('select a.id, a.user_id as uid, a.foto
        //     // from siswas as a
        //     // join users as u on u.id = a.user_id
        //     // where a.id = ?', [$id]);
        // }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.data-siswa', [
            'dataSiswa' => $this->getAllSiswa(),
            'dataKelas' => $this->getAllKelas(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailSiswa extends Component
{
    public $idu, $ids, $nis, $name, $id_kelas, $email, $no_hp, $peran, $jenis_kelamin, $alamat;

    public function mount($id)
    {
        $this->ids = $id;
    }

    public function updateSiswa()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'name' => 'required|min:3',
                'email' => 'required|email',
                'nis' => 'required|min:3',
                'id_kelas' => 'required',
            ]);

            // dd($this->name, $this->email, $this->nis, $this->id_kelas, $this->ids, $this->idu);
            $s = Siswa::find($this->ids)->update([
                'id_kelas' => $this->id_kelas,
                'nis' => $this->nis,
            ]);

            if ($s) {
                User::find($this->idu)->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
                session()->flash('pesan', 'Data berhasi diubah');
                return redirect(route('profilSID', ['id' => $this->ids]));
            } else {
                session()->flash('pesan', 'Data GAGAL diubah');
                return redirect(route('profilSID', ['id' => $this->ids]));
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function getByID()
    {
        $siswa = DB::select('select s.id, s.user_id, s.nis, u.name, u.email, s.id_kelas,
        k.nama_kelas, r.display_name as peran, s.foto, s.jenis_kelamin, s.no_hp, s.alamat
        from siswas as s
        join kelas as k on k.id = s.id_kelas
        join users as u on u.id = s.user_id
        join role_user as ru on ru.user_id = u.id 
        join roles AS r on r.id = ru.role_id
        where s.id = ?', [$this->ids]);

        foreach ($siswa as $key) {
            $this->idu = $key->user_id;
            $this->nis = $key->nis;
            $this->name = $key->name;
            $this->id_kelas = $key->id_kelas;
            $this->email = $key->email;
        }
        return $siswa;
    }

    public function getAllKelas()
    {
        $kelas = DB::select('select * from kelas');
        return $kelas;
    }

    public function cekJurusan()
    {
        $cek = DB::table('jurusans')->count();
        return $cek;
    }

    public function cekDaftarMapel()
    {
        $cek = DB::table('mapels')->count();
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
        return view('livewire.admin.detail-siswa', [
            'detailSiswa' => $this->getByID(),
            'dataKelas' => $this->getAllKelas(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

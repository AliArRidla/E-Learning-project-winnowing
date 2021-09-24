<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilUser extends Component
{
    use WithFileUploads;
    public $idR, $idU, $foto, $nip, $name, $jabatan, $email, $no_hp, $peran, $jenis_kelamin, $alamat, $nis, $nama_kelas;
    public $cfoto, $old_email, $old_nip;

    protected $messages = [
        'name.required' => 'Mohon isi kolom Nama',
        'name.min' => 'Mohon isi kolom Nama minimal 3 karakter.',
        'email.required' => 'Mohon isi kolom Email',
        'email.email' => 'Format Email tidak valid.',
        'email.unique' => 'Email sudah terpakai. Mohon gunakan yang lain.',
        'password.required' => 'Mohon isi kolom Password',
        'password.min' => 'Mohon isi kolom Password minimal 8 karakter.',
        'id_kelas.required' => 'Mohon pilih salah satu Nama Kelas',
        'jenis_kelamin.required' => 'Mohon pilih salah satu Jenis Kelamin.',
        'nip.required' => 'Mohon isi kolom NIP',
        'nip.min' => 'Mohon isi kolom NIP minimal 5 karakter.',
        'nip.unique' => 'NIS sudah terpakai. Mohon gunakan yang lain.',
        'nip.numeric' => 'NIP harus menggunakan nomor.',
        'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        'no_hp.min' => 'Mohon isi kolom Nomor HP minimal 5 karakter.',
        'alamat.required' => 'Mohon isi kolom Alamat',
    ];

    // public function mount($id)
    // {
    //     $this->idU = $id;
    // }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.foto, g.nip, u.name, g.jabatan, u.email, g.no_hp, 
            r.display_name as peran, g.jenis_kelamin, g.alamat
            from gurus as g
            join users as u on u.id = g.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where u.id = ?', [$id]);

            // foreach ($data as $d) {
            //     $this->idR = $d->rid;
            //     $this->foto = $d->foto;
            //     $this->nip = $d->nip;
            //     $this->name = $d->name;
            //     $this->jabatan = $d->jabatan;
            //     $this->email = $d->email;
            //     $this->no_hp = $d->no_hp;
            //     $this->peran = $d->peran;
            //     $this->jenis_kelamin = $d->jenis_kelamin;
            //     $this->alamat = $d->alamat;
            // }

            return $data;
        } else if (Auth::user()->hasRole('admin')) {
            $data = DB::select('select a.id as rid, a.foto, a.nip, u.name, a.jabatan, u.email, a.no_hp, 
            r.display_name as peran, a.jenis_kelamin, a.alamat
            from admins as a
            join users as u on u.id = a.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where u.id = ?', [$id]);

            // foreach ($data as $d) {
            //     $this->idR = $d->rid;
            //     $this->foto = $d->foto;
            //     $this->nip = $d->nip;
            //     $this->name = $d->name;
            //     $this->jabatan = $d->jabatan;
            //     $this->email = $d->email;
            //     $this->no_hp = $d->no_hp;
            //     $this->peran = $d->peran;
            //     $this->jenis_kelamin = $d->jenis_kelamin;
            //     $this->alamat = $d->alamat;
            // }

            return $data;
        } else if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select s.id as rid, s.user_id as uid, s.foto, s.nis, u.name, k.nama_kelas, u.email, s.no_hp, 
            r.display_name as peran, s.jenis_kelamin, s.alamat
            from siswas as s
            join users as u on u.id = s.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            join kelas AS k on k.id = s.id_kelas
            where u.id = ?', [$id]);

            // foreach ($data as $d) {
            //     $this->idR = $d->rid;
            //     $this->foto = $d->foto;
            //     $this->name = $d->name;
            //     $this->email = $d->email;
            //     $this->no_hp = $d->no_hp;
            //     $this->peran = $d->peran;
            //     $this->jenis_kelamin = $d->jenis_kelamin;
            //     $this->alamat = $d->alamat;
            //     $this->nis = $d->nis;
            //     $this->nama_kelas = $d->nama_kelas;
            // }

            return $data;
        } else {
            return redirect(route('login'));
        }
        // else if (Auth::user()->hasRole('siswa')) {
        //     // $data = DB::select('select a.id, a.user_id as uid, a.foto, a.nip, u.name, a.jabatan, u.email, a.no_hp, 
        //     // r.display_name as peran, a.jenis_kelamin, a.alamat
        //     // from siswas as a
        //     // join users as u on u.id = a.user_id
        //     // join role_user as ru on ru.user_id = u.id 
        //     // join roles AS r on r.id = ru.role_id
        //     // where a.id = ?', [$id]);
        // }
        // return $data;
    }

    public function loadData()
    {
        $data = $this->getAcc(Auth::user()->id);
        foreach ($data as $d) {
            $this->idR = $d->rid;
            $this->foto = $d->foto;
            $this->name = $d->name;
            $this->email = $d->email;
            $this->old_email = $d->email;
            $this->no_hp = $d->no_hp;
            $this->peran = $d->peran;
            $this->jenis_kelamin = $d->jenis_kelamin;
            $this->alamat = $d->alamat;
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('guru')) {
                $this->nip = $d->nip;
                $this->old_nip = $d->nip;
                $this->jabatan = $d->jabatan;
            } else if (Auth::user()->hasRole('siswa')) {
                $this->nis = $d->nis;
                $this->nama_kelas = $d->nama_kelas;
            }
        }
    }

    public function updateProfil()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('guru') || Auth::user()->hasRole('siswa')) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('guru')) {

                if ($this->old_email == $this->email && $this->old_nip == $this->nip) {
                    $valDataa = $this->validate([
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        'email' => 'required|email',
                        'nip' => 'numeric|min:5',
                    ]);
                } else if ($this->old_email == $this->email && $this->old_nip != $this->nip) {
                    $valDataa = $this->validate([
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        'email' => 'required|email',
                        'nip' => 'numeric|min:5|unique:gurus,nip',
                    ]);
                } else if ($this->old_email != $this->email && $this->old_nip == $this->nip) {
                    $valDataa = $this->validate([
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        'email' => 'required|email|unique:users',
                        'nip' => 'numeric|min:5',
                    ]);
                } else {
                    $valDataa = $this->validate([
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        'email' => 'required|email|unique:users',
                        'nip' => 'numeric|min:5|unique:gurus,nip',
                    ]);
                }
            } else if (Auth::user()->hasRole('siswa')) {
                if ($this->old_email == $this->email) {
                    $valDataa = $this->validate([
                        // 'nis' => 'numeric|min:5',
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'email' => 'required|email',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        // 'id_kelas' => 'required',
                    ]);
                } else {
                    $valDataa = $this->validate([
                        // 'nis' => 'numeric|min:5',
                        'no_hp' => 'numeric|min:5',
                        'name' => 'min:3',
                        'email' => 'required|email|unique:users',
                        'jenis_kelamin' => 'required',
                        'alamat' => 'required',
                        // 'id_kelas' => 'required',
                    ]);
                }
            }

            if ($valDataa) {
                if (Auth::user()->hasRole('guru')) {
                    Guru::find($this->idR)->update($this->modelData());
                } else if (Auth::user()->hasRole('admin')) {
                    Admin::find($this->idR)->update($this->modelData());
                } else if (Auth::user()->hasRole('siswa')) {
                    Siswa::find($this->idR)->update($this->modelData());
                }
                User::find(Auth::user()->id)->update($this->modelData());
                session()->flash('pesan', 'Data berhasil diubah');
                return redirect(route('profilAcc', ['id' => Auth::user()->id]));
            } else {
                session()->flash('pesan', 'Data GAGAL diubah');
                return redirect(route('profilAcc', ['id' => Auth::user()->id]));
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function modelData()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('guru')) {
            return [
                'nip' => $this->nip,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'jabatan' => $this->jabatan,
                'name' => $this->name,
                'email' => $this->email,
            ];
        } else if (Auth::user()->hasRole('siswa')) {
            return [
                // 'nis' => $this->nis,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                // 'jabatan' => $this->jabatan,
                'name' => $this->name,
                'email' => $this->email,
            ];
        }
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

    public function getDMap()
    {
        $dMap = DB::select(
            'select dm.id as dmid, u.name, m.nama_mapel, k.nama_kelas 
            from detail_mapels as dm
            join gurus as g on dm.id_guru = g.id
            join users as u on g.user_id = u.id
            join mapels as m on dm.id_mapel = m.id
            join kelas as k on dm.id_kelas = k.id
            where g.user_id = ?
            order by k.nama_kelas asc',
            [Auth::user()->id]
        );
        return $dMap;
    }

    public function getNavMap()
    {
        $dMap = DB::select(
            'select dm.id as dmid, m.nama_mapel
            from siswas as s
            join detail_mapels as dm on dm.id_kelas = s.id_kelas
            join mapels as m on dm.id_mapel = m.id
            where s.user_id = ?
            order by m.nama_mapel asc',
            [Auth::user()->id]
        );

        return $dMap;
    }

    public function render()
    {
        // return view('livewire.profil-user')->layout('layouts.layt');
        if (Auth::user()->hasRole('admin')) {
            return view('livewire.profil-user', [
                'dataAcc' => $this->getAcc(Auth::user()->id),
            ])->layout('layouts.layt', [
                'cekJurusan' => $this->cekJurusan(),
                'jmlKelas' => $this->countKelas(),
                'cekDaftarMapel' => $this->cekDaftarMapel(),
            ]);
        } else if (Auth::user()->hasRole('guru')) {
            return view('livewire.profil-user', [
                'dataAcc' => $this->getAcc(Auth::user()->id),
            ])->layout('layouts.layt', [
                'getDMapGuru' => $this->getDMap(),
            ]);
        } else if (Auth::user()->hasRole('siswa')) {
            return view('livewire.profil-user', [
                'dataAcc' => $this->getAcc(Auth::user()->id),
            ])->layout('layouts.layt', [
                'getNavMapSiswa' => $this->getNavMap(),
            ]);
        }
    }
}

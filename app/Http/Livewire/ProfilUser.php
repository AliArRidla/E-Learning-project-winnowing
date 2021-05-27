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
    public $cfoto;

    public function mount($id)
    {
        $this->idU = $id;
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto, g.nip, u.name, g.jabatan, u.email, g.no_hp, 
            r.display_name as peran, g.jenis_kelamin, g.alamat
            from gurus as g
            join users as u on u.id = g.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where u.id = ?', [$id]);
        } else if (Auth::user()->hasRole('admin')) {
            $data = DB::select('select a.id as rid, a.user_id as uid, a.foto, a.nip, u.name, a.jabatan, u.email, a.no_hp, 
            r.display_name as peran, a.jenis_kelamin, a.alamat
            from admins as a
            join users as u on u.id = a.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where u.id = ?', [$id]);
        } else if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select s.id as rid, s.user_id as uid, s.foto, s.nis, u.name, k.nama_kelas, u.email, s.no_hp, 
            r.display_name as peran, s.jenis_kelamin, s.alamat
            from siswas as s
            join users as u on u.id = s.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            join kelas AS k on k.id = s.id_kelas
            where u.id = ?', [$id]);
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
        return $data;
    }

    public function loadData()
    {
        $data = $this->getAcc(Auth::user()->id);
        foreach ($data as $d) {
            $this->idR = $d->rid;
            $this->foto = $d->foto;
            $this->name = $d->name;
            $this->email = $d->email;
            $this->no_hp = $d->no_hp;
            $this->peran = $d->peran;
            $this->jenis_kelamin = $d->jenis_kelamin;
            $this->alamat = $d->alamat;
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('guru')) {
                $this->nip = $d->nip;
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
                $valDataa = $this->validate([
                    'nip' => 'numeric|min:5',
                    'no_hp' => 'numeric|min:5',
                    'name' => 'min:3',
                    'email' => 'required|email',
                    'jenis_kelamin' => 'required',
                    'alamat' => 'required',
                    'jabatan' => 'required',
                ]);
            } else if (Auth::user()->hasRole('siswa')) {
                $valDataa = $this->validate([
                    'nis' => 'numeric|min:5',
                    'no_hp' => 'numeric|min:5',
                    'name' => 'min:3',
                    'email' => 'required|email',
                    'jenis_kelamin' => 'required',
                    'alamat' => 'required',
                    // 'id_kelas' => 'required',
                ]);
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

    // public function crop(Request $request)
    // {
    //     $path = 'storage/profilPic/';
    //     $file = $request->file('foto');
    //     $new_image_name = 'ProfilPic' . date('Ymd') . uniqid() . '.jpg';
    //     // dd($new_image_name);
    //     $upload = $file->move(public_path($path), $new_image_name);
    //     if ($upload) {
    //         return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
    //     } else {
    //         return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
    //     }
    // }

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
                'nis' => $this->nis,
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

    public function countKelas()
    {
        $jmlKelas = DB::table('kelas')->count();
        // dd($jmlGuru);
        return $jmlKelas;
    }

    public function render()
    {
        // return view('livewire.profil-user')->layout('layouts.layt');
        return view('livewire.profil-user', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
        ]);
    }
}

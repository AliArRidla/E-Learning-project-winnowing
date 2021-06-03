<?php

namespace App\Http\Livewire\Admin;

use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataKelas extends Component
{
    public $idk, $nama_kelas, $id_jurusan;
    public $add = false, $edit = false;

    public function addKelas()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'id_jurusan' => 'required',
                'nama_kelas' => 'required|string|min:3',
            ]);

            // dd($this->id_jurusan, $this->nama_kelas);

            $kelas = Kelas::create([
                'id_jurusan' => $this->id_jurusan,
                'nama_kelas' => $this->nama_kelas,
            ]);
            if ($kelas) {
                return redirect(route('dataKelas'));
                session()->flash('msg', 'Data berhasil ditambah');
            } else {
                return redirect(route('dataKelas'));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function editKelas()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'id_jurusan' => 'required',
                'nama_kelas' => 'required|string|min:3',
            ]);

            // dd($this->id_jurusan, $this->nama_kelas);

            $k = Kelas::find($this->idk)->update([
                'id_jurusan' => $this->id_jurusan,
                'nama_kelas' => $this->nama_kelas,
            ]);
            if ($k) {
                return redirect(route('dataKelas'));
                session()->flash('msg', 'Data berhasil diubah');
            } else {
                return redirect(route('dataKelas'));
                session()->flash('msg', 'Data GAGAL diubah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function getAll()
    {
        if (Auth::user()->hasRole('admin')) {
            $kelas = DB::select('select j.id as jid, j.nama_jurusan, k.id as kid, k.nama_kelas 
            from kelas as k
            join jurusans as j on j.id = k.id_jurusan');
            return $kelas;
        } else {
            return redirect(route('login'));
        }
    }

    public function getJurusan()
    {
        return DB::select('select * from jurusans');
    }

    public function deleteKelas($idk)
    {
        $delKelas = Kelas::find($idk);
        // dd($delKelas);
        $delKelas->delete();
        return redirect(route('dataKelas'));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    public function loadByID($idk)
    {
        $this->idk = $idk;
        $data = Kelas::find($this->idk);
        // foreach ($data as $d) {
        $this->id_jurusan = $data['id_jurusan'];
        $this->nama_kelas = $data['nama_kelas'];
        // }
        // $jurusan = DB::select('select * from jurusans where id = ?', [$idj]);
        // foreach ($jurusan as $i) {
        //     $this->idj = $i->id;
        //     $this->nama_jurusan = $i->nama_jurusan;
        // }
        // return $jurusan;
    }

    // public function getByID()
    // {
    //     // $this->idj = $idj;
    //     $data = Jurusan::find($this->idj);
    //     $this->nama_jurusan = $data->nama_jurusan;
    // }

    public function toogleModalAddEdit($act, $idk)
    {
        $this->idk = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edit = false;
        } else if ($act == 'edit') {
            $this->add = false;
            $this->edit = true;
            if ($idk > 0) {
                $this->idk = $idk;
                $this->loadByID($this->idk);
            }
        }
    }

    public function reload()
    {
        return redirect(route('dataKelas'));
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
        return view('livewire.admin.data-kelas', [
            'dataKelas' => $this->getAll(),
            'dataJurusan' => $this->getJurusan(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

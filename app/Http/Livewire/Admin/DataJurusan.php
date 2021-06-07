<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataJurusan extends Component
{
    public $idj, $nama_jurusan;
    public $add = false, $edit = false;

    public function addJurusan()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_jurusan' => 'required|string|min:3',
            ]);

            $jurusan = Jurusan::create([
                'nama_jurusan' => $this->nama_jurusan,
            ]);
            if ($jurusan) {
                return redirect(route('dataJurusan'));
                session()->flash('msg', 'Data berhasil ditambah');
            } else {
                return redirect(route('dataJurusan'));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function editJurusan()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_jurusan' => 'required|string|min:3',
            ]);

            // dd($this->nama_jurusan);

            $j = Jurusan::find($this->idj)->update(['nama_jurusan' => $this->nama_jurusan]);
            if ($j) {
                return redirect(route('dataJurusan'));
                session()->flash('msg', 'Data berhasil diubah');
            } else {
                return redirect(route('dataJurusan'));
                session()->flash('msg', 'Data GAGAL diubah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function getAll()
    {
        if (Auth::user()->hasRole('admin')) {
            $jurusan = DB::select('select * from jurusans');
            return $jurusan;
        } else {
            return redirect(route('login'));
        }
    }

    public function deleteJurusan($idj)
    {
        $delJurusan = Jurusan::find($idj);
        // dd($delJurusan);
        $delJurusan->delete();
        return redirect(route('dataJurusan'));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    public function loadByID($idj)
    {
        $this->idj = $idj;
        $data = Jurusan::find($this->idj);
        if($data== null){
            $this->nama_jurusan = '';
        }
        else{
            $this->nama_jurusan = $data['nama_jurusan'];
        }
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

    public function toogleModalAddEdit($act, $idj)
    {
        $this->idj = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edit = false;
        } else if ($act == 'edit') {
            $this->add = false;
            $this->edit = true;
            if ($idj > 0) {
                $this->idj = $idj;
                $this->loadByID($this->idj);
            }
        }
    }

    public function reload()
    {
        return redirect(route('dataJurusan'));
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
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.data-jurusan', [
            'dataJurusan' => $this->getAll(),
            'jurusanByID' => $this->loadByID($this->idj),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

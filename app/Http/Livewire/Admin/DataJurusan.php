<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataJurusan extends Component
{
    public $idj = null, $nama_jurusan;
    public $edt = null, $add = null, $del = null;

    protected $messages = [
        'nama_jurusan.required' => 'Mohon isi kolom Nama Jurusan',
        'nama_jurusan.min' => 'Mohon isi kolom Nama Jurusan minimal 3 karakter.',
    ];

    public function addJurusan()
    {
        //console.log("LOG");
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_jurusan' => 'required|string|min:3',
            ]);

            $jurusan = Jurusan::create([
                'nama_jurusan' => $this->nama_jurusan,
            ]);
            if ($jurusan) {
                session()->flash('pesan-s', 'Data berhasil ditambah');
                return redirect(route('dataJurusan'));
            } else {
                session()->flash('pesan-e', 'Data GAGAL ditambah');
                return redirect(route('dataJurusan'));
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function edtFalse()
    {
        $this->edt = false;
        $this->idj = null;
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
                session()->flash('pesan-s', 'Data berhasil diubah');
                return redirect(route('dataJurusan'));
            } else {
                session()->flash('pesan-e', 'Data GAGAL diubah');
                return redirect(route('dataJurusan'));
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
        session()->flash('pesan-s', 'Data berhasil dihapus');
        return redirect(route('dataJurusan'));
    }

    public function loadByID($idj)
    {
        // $this->edt = true;
        $this->idj = $idj;
        $data = Jurusan::find($this->idj);
        if ($data == null) {
            $this->nama_jurusan = '';
        } else {
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

    public function toogleModal($act, $idj)
    {
        $this->idj = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edt = null;
            $this->del = null;
        } else if ($act == 'edt') {
            $this->add = null;
            $this->edt = true;
            $this->del = null;
            if ($idj != null) {
                $this->idj = $idj;
                $this->loadByID($this->idj);
            }
        } else if ($act == 'del') {
            $this->add = null;
            $this->edt = null;
            $this->del = true;
            if ($idj != null) {
                $this->idj = $idj;
                $this->loadByID($this->idj);
            }
        }
    }

    public function allNull()
    {
        $this->add = null;
        $this->edt = null;
        $this->del = null;
        $this->idj = null;
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

<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetailMapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataMapel extends Component
{
    public $nama_mapel, $mid;
    public $edt = null, $add = null, $del = null;

    protected $messages = [
        'nama_mapel.required' => 'Mohon isi kolom Nama Mapel',
        'nama_mapel.min' => 'Mohon isi kolom Nama Mapel minimal 3 karakter.',
        'nama_mapel.unique' => 'Nama Mapel sudah ada',
    ];

    public function addMapel()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_mapel' => 'required|min:3|unique:mapels,nama_mapel',
                // 'id_kelas' => 'required',
                // 'id_guru' => 'required',
            ]);

            // dd($this->nama_mapel, $this->id_kelas, $this->id_guru);

            $map = Mapel::create([
                'nama_mapel' => $this->nama_mapel,
            ]);

            // $dmap = DetailMapel::create([
            //     'id_mapel' => $map->id,
            //     'id_kelas' => $this->id_kelas,
            //     'id_guru' => $this->id_guru,
            // ]);

            if ($map) {
                // $this->reset();
                session()->flash('pesan-s', 'Data berhasil ditambah');
                return redirect(route('dataMapel'));
            } else {
                session()->flash('pesan-e', 'Data GAGAL ditambah');
                return redirect(route('dataMapel'));
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function editMapel()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_mapel' => 'required|min:3',
                // 'id_kelas' => 'required',
                // 'id_guru' => 'required',
            ]);

            // dd($this->nama_mapel);

            $map = Mapel::find($this->mid)->update(['nama_mapel' => $this->nama_mapel]);
            // $dmap = DetailMapel::find($this->dmid)->update([
            //     'id_kelas' => $this->id_kelas,
            //     'id_guru' => $this->id_guru,
            // ]);

            if ($map) {
                session()->flash('pesan-s', 'Data berhasil diubah');
                return redirect(route('dataMapel'));
            } else {
                session()->flash('pesan-e', 'Data GAGAL diubah');
                return redirect(route('dataMapel'));
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function deleteMapel($mid)
    {
        // dd($mid);
        $delMapel = Mapel::find($mid);
        // dd($delMapel);
        $delMapel->delete();
        session()->flash('pesan-s', 'Data berhasil dihapus');
        return redirect(route('dataMapel'));
    }

    public function getAllKelas()
    {
        return DB::table('kelas')->get();
    }

    public function getAllMapel()
    {
        return DB::table('mapels')->get();
    }

    public function getAllGuru()
    {
        $guru = DB::select('select g.id, u.name from gurus as g
        join users as u on u.id = g.user_id');
        return $guru;
    }

    public function loadByID($mid)
    {
        $this->mid = $mid;

        $map = Mapel::find($this->mid);
        $this->nama_mapel = $map['nama_mapel'];
    }

    public function toogleModal($act, $mid)
    {
        $this->mid = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edt = null;
            $this->del = null;
        } else if ($act == 'edt') {
            $this->add = null;
            $this->edt = true;
            $this->del = null;
            if ($mid != null) {
                $this->mid = $mid;
                $this->loadByID($this->mid);
            }
        } else if ($act == 'del') {
            $this->add = null;
            $this->edt = null;
            $this->del = true;
            if ($mid != null) {
                $this->mid = $mid;
                $this->loadByID($this->mid);
            }
        }
    }

    public function allNull()
    {
        $this->add = null;
        $this->edt = null;
        $this->del = null;
        $this->mid = null;
    }

    public function reload()
    {
        return redirect(route('dataMapel'));
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
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.data-mapel', [
            'dataGuru' => $this->getAllGuru(),
            'dataKelas' => $this->getAllKelas(),
            'dataMapel' => $this->getAllMapel(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

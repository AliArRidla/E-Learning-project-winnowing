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
    public $add = false, $edit = false;

    public function addMapel()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->validate([
                'nama_mapel' => 'required|min:3',
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
                return redirect(route('dataMapel'));
                session()->flash('msg', 'Data berhasil diubah');
            } else {
                return redirect(route('dataMapel'));
                session()->flash('msg', 'Data GAGAL diubah');
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
                return redirect(route('dataMapel'));
                session()->flash('msg', 'Data berhasil diubah');
            } else {
                return redirect(route('dataMapel'));
                session()->flash('msg', 'Data GAGAL diubah');
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
        return redirect(route('dataMapel'));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    // public function getAllMapel()
    // {
    //     // $mapel = DB::select('select *
    //     // from detail_mapels as dm
    //     // join mapel as m on m.id = dm.id_mapel
    //     // join kelas as k on k.id = dm.id_kelas
    //     // join guru as g on g.id = dm.id_guru
    //     // join users as u on u.id = g.user_id
    //     // join role_user as ru on ru.user_id = u.id 
    //     // join roles AS r on r.id = ru.role_id
    //     // where r.name = ?', ['guru']);
    //     $mapel = DB::select('select dm.id, m.nama_mapel, k.nama_kelas, u.name
    //     from detail_mapels as dm
    //     join mapels as m on m.id = dm.id_mapel
    //     join kelas as k on k.id = dm.id_kelas
    //     join gurus as g on g.id = dm.id_guru
    //     join users as u on u.id = g.user_id');

    //     // foreach ($mapel as $m) {
    //     //     $this->dmid = $m->id;
    //     //     $this->nama_mapel = $m->nama_mapel;
    //     //     $this->nama_kelas = $m->nama_kelas;
    //     //     $this->nama_guru = $m->name;
    //     // }

    //     return $mapel;
    // }
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
        // $data = DetailMapel::find($this->mid);
        // // foreach ($data as $d) {
        // $this->id_mapel = $data['id_mapel'];
        // $this->id_kelas = $data['id_kelas'];
        // $this->id_guru = $data['id_guru'];

        $map = Mapel::find($this->mid);
        $this->nama_mapel = $map['nama_mapel'];

        // $dkelas = Kelas::find($this->id_kelas);
        // $this->nama_kelas = $dkelas['nama_kelas'];

        // $dguru = Guru::find($this->id_guru);
        // $this->id_guru = $dguru['id'];
        // $this->id_user = $dguru['user_id'];

        // $duser = User::find($this->id_user);
        // $this->name = $duser['name'];
        // }
        // $jurusan = DB::select('select * from jurusans where id = ?', [$idj]);
        // foreach ($jurusan as $i) {
        //     $this->idj = $i->id;
        //     $this->nama_jurusan = $i->nama_jurusan;
        // }
        // return $jurusan;
    }

    public function toogleModalAddEdit($act, $mid)
    {
        $this->mid = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edit = false;
        } else if ($act == 'edit') {
            $this->add = false;
            $this->edit = true;
            if ($mid > 0) {
                $this->mid = $mid;
                $this->loadByID($this->mid);
            }
        }
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

<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataMateri extends Component
{
    public $nav_dmid, $mData, $tData, $nama_tugas, $matid, $tid, $dmid, $id_mats;

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }
    
    public function getMateri($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select count(mat.id) as cmid, dm.id as dmid, m.nama_mapel, mat.nama_materi,mat.id as matid
            from materis as mat
            join detail_mapels as dm on mat.id_detMapel = dm.id
            join mapels as m on m.id = dm.id_mapel
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            where s.user_id = ? and mat.id_detMapel = ?
            group by dm.id, m.nama_mapel, mat.nama_materi, mat.id
            order by mat.nama_materi asc', [$id, $this->nav_dmid]);
            $this->mData = $data;
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    //SELECT t.nama_tugas from tugas as t JOIN materis as m on m.id = t.id_materi WHERE m.id = '1'
    public function getTugas($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select dm.id as dmid, t.nama_tugas
            from materis as mat
            join detail_mapels as dm on mat.id_detMapel = dm.id
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            join tugas as t on t.id_materi = mat.id
            where s.user_id = ? and mat.id_detMapel = ?', [$id, $this->nav_dmid]);
            $this->tData = $data;
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    public function getTgs($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select t.nama_tugas, t.content 
                FROM materis as m 
                join detail_mapels as dm on dm.id= m.id_detMapel 
                JOIN tugas as t on t.id_materi = m.id 
                WHERE m.id = ? and dm.id = ?',[$id, $this->dmid]);
            return $data;
        } else {
            return redirect(route('login'));
        }
    }
    
    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select s.id as rid, s.user_id as uid, s.foto
            from siswas as s
            join users as u on u.id = s.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        return $data;
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
        return view('livewire.siswa.data-materi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMateri' => $this->getMateri(Auth::user()->id),
            'dataTugas' => $this->getTugas(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataTugas extends Component
{
    public $nav_dmid, $tData, $nama_tugas;

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }

    public function getTugas($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select count(m.id) as cmid, dm.id as dmid, m.nama_mapel
            from materis as mat
            join detail_mapels as dm on mat.id_detMapel = dm.id
            join mapels as m on m.id = dm.id_mapel
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            join tugas as t on t.id_materi = mat.id
            where s.user_id = ? 
            group by dm.id, m.nama_mapel
            order by m.nama_mapel asc', [$id]);
            $this->tData = $data;
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    public function getTgs($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $tgs = DB::select('select dm.id as dmid, t.nama_tugas
            from detail_mapels as dm
            join gurus as g on g.id = dm.id_guru
            join kelas as k on k.id = dm.id_kelas
            join siswas as s on s.id_kelas = k.id
            join users as u on u.id = s.user_id
            join materis as mat on mat.id_detMapel = dm.id
            JOIN tugas as t on t.id_materi = mat.id 
            where s.user_id = ?
            group by dm.id, t.nama_tugas
            order by t.nama_tugas asc', [$id]);
            return $tgs;
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
        return view('livewire.siswa.data-tugas', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataTugas' => $this->getTugas(Auth::user()->id),
            'dataTgs' => $this->getTgs(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

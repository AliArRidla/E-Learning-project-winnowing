<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataTugasEdit extends Component
{
    public $nav_dmid, $idTgs;
    public $countDM = 0;

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $tugas = DB::select('select m.id as mid, m.nama_materi, dm.id as dmid 
                from materis as m
                join detail_mapels as dm on dm.id = m.id_detMapel
                WHERE dm.id=?', [$id]);
            return $tugas;
        } else {
            return redirect(route('login'));
        }
    }
    
    public function mount($nav_dmid, $idTgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->idTgs = $idTgs;
    }

    public function reload()
    {
        return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        return $data;
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

        foreach ($dMap as $k) {
            $this->countDM++;
        }

        return $dMap;
    }
    
    public function render()
    {
        return view('livewire.guru.data-tugas-edit', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'tugas' => $this->getAll($this->nav_dmid),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

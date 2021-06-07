<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataMateriTambah extends Component
{
    public $nav_dmid;
    public $countDM = 0;

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $materi = DB::select('select m.nama_mapel, k.nama_kelas, dm.id as dmid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            where dm.id = ?', [$id]);
            return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }

    public function reload()
    {
        return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
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
        return view('livewire.guru.data-materi-tambah', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'materi' => $this->getAll($this->nav_dmid),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

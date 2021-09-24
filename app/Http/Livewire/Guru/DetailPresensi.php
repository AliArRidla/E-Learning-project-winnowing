<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailPresensi extends Component
{
    public $id_pres, $nav_dmid;

    public function mount($nav_dmid, $id_pres)
    {
        $this->id_pres = $id_pres;
        $this->nav_dmid = $nav_dmid;
    }

    public function getAbsen()
    {
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select id, hari_absen, jangka_waktu
                from presensis
                where id = ?', [$this->id_pres]);
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    public function getPres()
    {
        $pres = DB::select('select m.nama_mapel, k.nama_kelas 
        from presensis as p
        join detail_mapels as dm on p.id_det_mapel = dm.id
        join mapels as m on m.id = dm.id_mapel
        join kelas as k on dm.id_kelas = k.id
        where p.id = ?', [$this->id_pres]);

        return $pres;
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

        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.detail-presensi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataPres' => $this->getPres(),
            'dataAbsen' => $this->getAbsen(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

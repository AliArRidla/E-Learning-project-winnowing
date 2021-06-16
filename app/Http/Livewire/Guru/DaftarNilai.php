<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DaftarNilai extends Component
{
    public $nav_dmid, $nama_mapel, $nama_kelas, $dTgs;

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;

        $dm = DB::select('select m.nama_mapel, k.nama_kelas 
        from detail_mapels as dm 
        join mapels as m on dm.id_mapel = m.id
        join kelas as k on dm.id_kelas = k.id
        where dm.id = ?', [$nav_dmid]);

        foreach ($dm as $d) {
            $this->nama_mapel = $d->nama_mapel;
            $this->nama_kelas = $d->nama_kelas;
        }
    }

    public function ddMe()
    {
        dd($this->dTgs);
    }

    public function getTugas($dmid)
    {
        $gt = DB::select('select t.id from tugas as t
        join materis as m on m.id = t.id_materi
        join detail_mapels as dm on dm.id = m.id_detMapel
        where dm.id = ?
        order by t.created_at asc', [$dmid]);
        return $gt;
    }

    public function getUlangans($dmid)
    {
        $gu = DB::select('select u.id
        from ulangans as u
        join detail_mapels as dm on dm.id = u.id_det_mapel
        where dm.id = ?
        order by u.created_at asc', [$dmid]);
        return $gu;
    }

    public function getSiswa()
    {
        $gs = DB::select('select s.id, u.name from siswas as s 
        join users as u on u.id = s.user_id
        join kelas as k on k.id = s.id_kelas
        join detail_mapels as dm on dm.id_kelas = s.id_kelas
        where dm.id = ?', [$this->nav_dmid]);
        return $gs;
    }

    public function getAcc($id)
    {
        $data = null;
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
        return view('livewire.guru.daftar-nilai', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'getSiswa' => $this->getSiswa(),
            'getTugas' => $this->getTugas($this->nav_dmid),
            'getUlangan' => $this->getUlangans($this->nav_dmid),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

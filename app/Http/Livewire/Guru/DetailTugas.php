<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailTugas extends Component
{
    public $nav_dmid, $id_tgs, $dtgs, $nama_mapel, $nama_kelas;

    public function mount($nav_dmid, $id_tgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_tgs = $id_tgs;

        $this->dtgs = $this->getTugas($id_tgs);

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

    public function getTugas($id_tgs)
    {
        $tgs = DB::select('select t.nama_tugas, t.content, t.file_tugas, t.tanggal, m.nama_materi 
        from tugas as t 
        join materis as m on m.id = t.id_materi
        where t.id = ?', [$id_tgs]);

        return $tgs;
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
        return view('livewire.guru.detail-tugas', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

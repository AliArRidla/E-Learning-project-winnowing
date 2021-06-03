<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListPresensi extends Component
{
    public $fData, $pids = array(), $statusClicked = false, $dData;

    public function findPres($dmid, $sc)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select p.id as pid, dm.id as dmid, m.nama_mapel
                from presensis as p
                join detail_mapels as dm on p.id_det_mapel = dm.id
                join mapels as m on m.id = dm.id_mapel
                join siswas as s on dm.id_kelas = s.id_kelas
                where s.user_id = ? and dm.id = ?', [Auth::user()->id, $dmid]);

            $this->fData = $data;

            if ($sc == 'clicked') {
                if (!$this->statusClicked) {
                    for ($i = 0; $i < count($this->fData); $i++) {
                        array_push($this->pids, $this->fData[$i]->pid);
                    }
                    $this->statusClicked = true;
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function ddMe()
    {
        dd($this->fData);
    }

    public function getAbsen($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select count(p.id) as cpid, dm.id as dmid, m.nama_mapel
            from presensis as p
            join detail_mapels as dm on p.id_det_mapel = dm.id
            join mapels as m on m.id = dm.id_mapel
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            where s.user_id = ? 
            group by dm.id, m.nama_mapel
            order by m.nama_mapel asc', [$id]);
            $this->fData = $data;
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    public function getPresensi()
    {
        $data = DB::select('select *
            from presensis as p
            join detail_mapels as dm on p.id_det_mapel = dm.id
            join mapels as m on m.id = dm.id_mapel
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            where s.user_id = 7
            group by dm.id, m.nama_mapel
            order by m.nama_mapel asc');

        $this->dData = $data;
        dd($this->dData);
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
        return view('livewire.siswa.list-presensi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataAbsen' => $this->getAbsen(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

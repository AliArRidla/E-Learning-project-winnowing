<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListUlangan extends Component
{
    public $nav_dmid, $nama_mapel, $nama_kelas, $id_siswa;

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;

        $d = DB::select(
            'select m.nama_mapel, k.nama_kelas 
        from detail_mapels as dm
        join kelas as k on dm.id_kelas = k.id
        join mapels as m on dm.id_mapel = m.id
        where dm.id = ? ',
            [$this->nav_dmid]
        );

        $this->nama_mapel = $d[0]->nama_mapel;
        $this->nama_kelas = $d[0]->nama_kelas;

        $dSis = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
        $this->id_siswa = $dSis[0]->id;
    }

    public function getUlanganSiswa()
    {
        if (Auth::user()->hasRole('siswa')) {
            $dataUl = DB::select(
                'select ul.id as id_ul, ul.judul_ulangan, ul.tgl_ulangan,
            ul.waktu_mulai, ul.waktu_selesai, k.nama_kelas, m.nama_mapel
            from ulangans as ul
            join detail_mapels as dm on dm.id = ul.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            join soals as so on so.id_ulangan = ul.id
            where dm.id = ?
            group by ul.id, ul.judul_ulangan, ul.tgl_ulangan,
            ul.waktu_mulai, ul.waktu_selesai, k.nama_kelas, m.nama_mapel',
                [$this->nav_dmid]
            );

            return $dataUl;
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
        return view('livewire.siswa.list-ulangan', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUlanganSiswa(),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

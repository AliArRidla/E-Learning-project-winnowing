<?php

namespace App\Http\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListSoal extends Component
{
    public $id_ul;

    public function mount($id_ul)
    {
        $this->id_ul = $id_ul;
    }

    public function getSoal()
    {
        $data = DB::select('select * from soals where id_ulangan = ?', [$this->id_ul]);
        return $data;
    }

    public function getDetUlangan($id_ul)
    {
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select ul.id as ulid, ul.id_det_mapel as ulidm, ul.judul_ulangan,
            k.nama_kelas, m.nama_mapel, ul.tgl_ulangan, ul.waktu_mulai, ul.waktu_selesai, ul.is_poin
            from ulangans as ul
            join detail_mapels as dm on dm.id = ul.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where ul.id = ?', [$id_ul]);

            // foreach ($data as $d) {
            //     $this->jmlSoal = DB::select(
            //         'select COUNT(*) AS jml FROM (
            //             SELECT soals.id FROM soals
            //             JOIN ulangans ON soals.id_ulangan = ulangans.id
            //             WHERE soals.id_ulangan = ?
            //         ) jml',
            //         [$d->ulid]
            //     );
            // }

            return $data;
        } else {
            return redirect(route('login'));
        }
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

        // foreach ($dMap as $k) {
        //     $this->countDM++;
        // }

        return $dMap;
    }

    // public function getMapel()
    // {
    //     if (Auth::user()->hasRole('guru')) {
    //         $data = DB::select('select dm.id as dmid, k.nama_kelas, m.nama_mapel
    //         from detail_mapels as dm
    //         join kelas as k on dm.id_kelas = k.id
    //         join mapels as m on dm.id_mapel = m.id
    //         where dm.id = ?', [$this->nav_dmid]);
    //         return $data;
    //     } else {
    //         return redirect(route('login'));
    //     }
    // }

    public function render()
    {
        return view('livewire.guru.list-soal', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            // 'dataMapel' => $this->getMapel(),
            'dataDetUl' => $this->getDetUlangan($this->id_ul),
            'dataSoal' => $this->getSoal(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\Guru;

use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $jml;

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

    public function countMapel()
    {
        $dataGuru = DB::select('select id from gurus where user_id = ?', [Auth::user()->id]);
        foreach ($dataGuru as $key) {
            $idg = $key->id;
        }

        $jmlMapel = DB::select(
            'select COUNT(*) AS jml FROM (
                SELECT mapels.nama_mapel FROM detail_mapels 
                JOIN mapels ON detail_mapels.id_mapel = mapels.id 
                WHERE detail_mapels.id_guru = ? 
                GROUP BY mapels.nama_mapel
            ) jml',
            [$idg]
        );

        // select COUNT(*) AS jml FROM ( SELECT kelas.nama_kelas FROM detail_mapels JOIN kelas ON detail_mapels.id_kelas = kelas.id WHERE detail_mapels.id_guru = 4 GROUP BY detail_mapels.id_kelas ) jml

        foreach ($jmlMapel as $key) {
            $jmlMap = $key->jml;
        }

        return $jmlMap;
    }

    public function countKelas()
    {
        $dataGuru = DB::select('select id from gurus where user_id = ?', [Auth::user()->id]);
        foreach ($dataGuru as $key) {
            $idg = $key->id;
        }

        $this->jml = DB::select(
            'select kelas.nama_kelas, kelas.id as kid FROM detail_mapels 
            JOIN kelas ON detail_mapels.id_kelas = kelas.id 
            WHERE detail_mapels.id_guru = ? 
            GROUP BY kelas.nama_kelas, kelas.id',
            [$idg]
        );

        return count($this->jml);
        // return $jml[0]->jml;
    }

    public function countSiswa()
    {
        // $dataGuru = DB::select('select id from gurus where user_id = ?', [Auth::user()->id]);
        // foreach ($dataGuru as $key) {
        //     $idg = $key->id;
        // }

        // $jml = DB::select(
        //     'select kelas.id as kid FROM detail_mapels 
        //     JOIN kelas ON detail_mapels.id_kelas = kelas.id 
        //     WHERE detail_mapels.id_guru = ?',
        //     [$idg]
        // );

        $sw = 0;
        foreach ($this->jml as $j) {
            $jmls = DB::select('select count(*) as jml from siswas where id_kelas = ?', [$j->kid]);
            $sw = $sw + intval($jmls[0]->jml);
        }

        // for ($i = 0; $i < count($jml); $i++) {
        //     $jmls = DB::select(
        //         'select COUNT(*) AS jmls FROM (
        //         SELECT siswas.id FROM siswas
        //         JOIN kelas ON kelas.id = siswas.id_kelas
        //         WHERE kelas.id = ?
        //     ) jmls',
        //         [$i]
        //     );
        //     $sw = $sw + intval($jmls[0]->jmls);
        // }

        return $sw;
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
        return view('livewire.guru.dashboard', [
            'jmlMapel' => $this->countMapel(),
            'jmlKelas' => $this->countKelas(),
            'jmlSiswa' => $this->countSiswa(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dMap' => $this->getDMap(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}
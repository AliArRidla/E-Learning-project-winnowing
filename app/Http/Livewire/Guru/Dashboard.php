<?php

namespace App\Http\Livewire\Guru;

use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    // public $idg;
    // public function countGuru()
    // {
    //     $jmlGuru = DB::table('gurus')->count();
    //     // dd($jmlGuru);
    //     return $jmlGuru;
    // }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        }
        // else if (Auth::user()->hasRole('admin')) {
        //     $data = DB::select('select a.id as rid, a.user_id as uid, a.foto
        //     from admins as a
        //     join users as u on u.id = a.user_id
        //     where u.id = ?', [$id]);
        // } 
        else {
            return redirect(route('login'));
        }
        // else if (Auth::user()->hasRole('siswa')) {
        //     // $data = DB::select('select a.id, a.user_id as uid, a.foto
        //     // from siswas as a
        //     // join users as u on u.id = a.user_id
        //     // where a.id = ?', [$id]);
        // }
        return $data;
    }

    public function countMapel()
    {
        $dataGuru = DB::select('select * from gurus where user_id = ?', [Auth::user()->id]);
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
        $dataGuru = DB::select('select * from gurus where user_id = ?', [Auth::user()->id]);
        foreach ($dataGuru as $key) {
            $idg = $key->id;
        }
        $jmlMapel = DB::table('detail_mapels')->where('id_guru', '=', $idg)->count();
        return $jmlMapel;
    }

    public function render()
    {
        return view('livewire.guru.dashboard', [
            'jmlMapel' => $this->countMapel(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt');
    }
}

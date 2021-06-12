<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetDataMateri extends Component
{
    public $nav_dmid, $id_mats;

    public function mount($nav_dmid, $id_mats)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_mats = $id_mats;
    }

    public function getMateri($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $materi = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid, 
            mat.nama_materi, mat.id as matid, mat.file_materi, mat.content
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join siswas as s on k.id = s.id_kelas
            join users as u on u.id = s.user_id
            join materis as mat on mat.id_detMapel = dm.id
            where mat.id=? and s.user_id = ?', [$this->id_mats, $id]);
            return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    public function download($id_mats)
    {
        $materi = Materi::findOrFail($id_mats);
        $fm = $materi->file_materi;
        return response()->download(public_path('storage/content/' . $fm));
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
        return view('livewire.siswa.det-data-materi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMat' => $this->getMateri(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

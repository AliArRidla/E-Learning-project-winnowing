<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardSiswa extends Component
{
    public $id_siswa, $id_kelas, $nama_kelas;

    public function mount()
    {
        $detSis = DB::select('select s.id as sid, k.id as kid, k.nama_kelas
        from siswas as s 
        join kelas as k on s.id_kelas = k.id
        where s.user_id = ?', [Auth::user()->id]);

        foreach ($detSis as $ds) {
            $this->id_siswa = $ds->sid;
            $this->id_kelas = $ds->kid;
            $this->nama_kelas = $ds->nama_kelas;
        }
    }
    public function getMapelSiswa()
    {
        $listMap = DB::select('select m.nama_mapel, u.name, dm.id as dmid
        from detail_mapels as dm
        join mapels as m on dm.id_mapel = m.id
        join kelas as k on dm.id_kelas = k.id
        join gurus as g on dm.id_guru = g.id
        join users as u on g.user_id = u.id
        where dm.id_kelas = ?
        order by m.nama_mapel asc', [$this->id_kelas]);

        return $listMap;
    }

    public function getTugas()
    {
        $listTugas = DB::select('select t.nama_tugas, t.tanggal, 
        t.id as tid, m.nama_mapel, dm.id as dmid
        from tugas as t
        join materis as mat on mat.id = t.id_materi
        join detail_mapels as dm on dm.id = mat.id_detMapel
        join mapels as m on dm.id_mapel = m.id
        where dm.id_kelas = ?', [$this->id_kelas]);
        
        // foreach($listTugas as lt){
            
        // }

        return $listTugas;
    }

    public function getUlangan()
    {
        $listUlangan = DB::select('select ul.judul_ulangan, ul.tgl_ulangan, 
        ul.id as ulid, ul.waktu_mulai, ul.waktu_selesai, dm.id as dmid
        from ulangans as ul
        join detail_mapels as dm on dm.id = ul.id_det_mapel
        where dm.id_kelas = ?', [$this->id_kelas]);

        return $listUlangan;
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
        return view('livewire.siswa.dashboard-siswa', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'mapels' => $this->getMapelSiswa(),
            'tugas' => $this->getTugas(),
            'ulangan' => $this->getUlangan(),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}
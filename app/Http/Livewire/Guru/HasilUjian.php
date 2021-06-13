<?php

namespace App\Http\Livewire\Guru;

use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HasilUjian extends Component
{
    public $nama_mapel, $nama_kelas, $id_ul, $judul_ulangan;

    public function mount($id_ul, $nav_dmid)
    {
        $dm = DB::select('select m.nama_mapel, k.nama_kelas 
        from detail_mapels as dm 
        join mapels as m on dm.id_mapel = m.id
        join kelas as k on dm.id_kelas = k.id
        where dm.id = ?', [$nav_dmid]);

        foreach ($dm as $d) {
            $this->nama_mapel = $d->nama_mapel;
            $this->nama_kelas = $d->nama_kelas;
        }

        $dUl = Ulangan::find($id_ul)->get();
        $this->judul_ulangan = $dUl[0]->judul_ulangan;

        $this->id_ul = $id_ul;
    }

    public function getHasil($id_ul)
    {
        $data = DB::select('select ul.tgl_ulangan, ul.waktu_mulai, 
        ul.waktu_selesai, u.name, nu.nilai, nu.benar, nu.salah,
        nu.created_at as pengumpulan from ulangans as ul
        join nilai_ulangans as nu on nu.id_ulangan = ul.id
        join siswas as s on s.id = nu.id_siswa
        join users as u on u.id = s.user_id
        where ul.id = ?', [$id_ul]);

        return $data;
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

    public function render()
    {
        return view('livewire.guru.hasil-ujian', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataHasil' => $this->getHasil($this->id_ul),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

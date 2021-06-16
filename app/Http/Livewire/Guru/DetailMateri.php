<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailMateri extends Component
{
    public $nav_dmid, $id_mat, $nama_mapel, $nama_kelas, $nama_materi, $file_materi, $content;

    public function mount($nav_dmid, $id_mat)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_mat = $id_mat;

        $detMat = DB::select('select * from materis where id = ?', [$id_mat]);
        foreach ($detMat as $dd) {
            $this->nama_materi = $dd->nama_materi;
            $this->file_materi = $dd->file_materi;
            $this->content = $dd->content;
        }

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

    // public function getMatByID()
    // {
    //     return Materi::find($this->id_mat)->get();
    // }

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
        return view('livewire.guru.detail-materi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            // 'dataMateri' => $this->getMatByID(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

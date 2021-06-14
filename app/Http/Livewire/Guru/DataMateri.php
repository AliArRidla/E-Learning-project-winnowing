<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataMateri extends Component
{
    public $nav_dmid, $nama_materi, $id_mat, $nama_mapel, $nama_kelas;
    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;

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

    public function loadMat($id)
    {
        $dMap = Materi::find($id)->get();
        foreach ($dMap as $key) {
            $this->nama_materi = $key->nama_materi;
            $this->id_mat = $key->id;
        }
    }

    public function delMat()
    {
        // $file_mat = null;
        $dMap = Materi::find($this->id_mat);
        // $file_mat = $dMap->file_materi;
        // dd();
        unlink('storage/file-materi/' . $dMap['file_materi']);
        $dMap->delete();
        session()->flash('pesan', 'Data berhasil dihapus');
        return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getMateri()
    {
        return DB::select('select * from materis where id_detMapel = ? order by created_at ASC', [$this->nav_dmid]);
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
        return view('livewire.guru.data-materi', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMat' => $this->getMateri(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

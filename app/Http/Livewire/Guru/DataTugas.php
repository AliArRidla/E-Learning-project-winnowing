<?php

namespace App\Http\Livewire\Guru;

use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTugas extends Component
{
    use WithFileUploads;
    public $tujuan, $id_tgs, $nama_tugas, $file_tugas, $content, $nav_dmid, $id_mat;
    public $nama_materi, $nama_mapel, $nama_kelas;
    public $countDM = 0;

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
    
    public function allNull()
    {
        $this->nama_materi = null;
        $this->id_mat = null;
    }

    public function loadTgs($id)
    {
        $this->id_tgs = $id;
        $tgs = Tugas::find($id);
        // foreach ($tgs as $key) {
        $this->nama_tugas = $tgs['nama_tugas'];
            // $this->id_tgs = $key->id;
        // }
    }

    public function delTgs()
    {
        // $file_mat = null;
        $tgs = Tugas::find($this->id_tgs);
        // $file_mat = $dMap->file_materi;
        // dd();
        if ($tgs['file_tugas'] != null) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/storage/public/file_tugas/' . $tgs['file_tugas']);
        }
        $tgs->delete();
        session()->flash('pesan', 'Data berhasil dihapus');
        return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getTugas()
    {
        return DB::select('select t.id, t.nama_tugas, t.updated_at, mat.nama_materi
            from tugas as t
            join materis as mat on mat.id = t.id_materi
            join detail_mapels as dm on dm.id = mat.id_detMapel
            where id_detMapel = ? order by t.created_at ASC', [$this->nav_dmid]);
    }

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $tugas = DB::select('select t.nama_tugas,t.tanggal, m.id as mid,m.nama_materi 
                FROM tugas as t 
                JOIN materis as m on m.id = t.id_materi 
                WHERE m.id=?', [$id]);
            return $tugas;
        } else {
            return redirect(route('login'));
        }
    }

    public function reload()
    {
        return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
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

        foreach ($dMap as $k) {
            $this->countDM++;
        }

        return $dMap;
    }


    public function render()
    {
        return view('livewire.guru.data-tugas', [
            'dataTugas' => $this->getAll($this->nav_dmid),
            'dataTgs' => $this->getTugas(Auth::user()->id),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

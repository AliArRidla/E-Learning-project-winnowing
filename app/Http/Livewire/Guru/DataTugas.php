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
    public $tujuan, $idTgs, $id_materi, $nama_tugas, $file_tugas, $content, $nav_dmid, $idTgas;
    public $togglePage = false;
    public $countDM = 0;
    
    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
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

    public function getTugas($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $tgs = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid, 
            t.nama_tugas,t.tanggal, mat.nama_materi, mat.id as matid, t.id as tid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            join materis as mat on mat.id_detMapel = dm.id
            JOIN tugas as t on t.id_materi = m.id 
            where g.user_id = ?', [$id]);
            return $tgs;
        } else {
            return redirect(route('login'));
        }
    }

    //buat edit
    public function loadByID($idTgas)
    {
        $this->idTgas = $idTgas;
        $data = Tugas::find($this->idTgas);
        // 'id_detMapel', 'nama_materi', 'desc_materi','content',
        $this->id_materi = $data['id_materi'];
        $this->nama_tugas = $data['nama_tugas'];
        $this->file_tugas = $data['file_tugas'];
        $this->content = $data['content'];
        $this->tanggal = $data['tanggal'];
    }

    public function reload()
    {
        return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getMateri()
    {
        return DB::select('select * from materis');
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

    public function deleteTugas($idTgas)
    {
        $tugas = Tugas::find($idTgas);
        unlink('storage/file_tugas/' . $tugas->file_tugas);
        $tugas->delete();
        return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.guru.data-tugas', [
            'dataTugas' => $this->getAll($this->nav_dmid),
            'dataTgs' => $this->getTugas(Auth::user()->id),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMtr' => $this->getMateri(Auth::user()->id),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

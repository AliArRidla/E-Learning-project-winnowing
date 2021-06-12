<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataMateri extends Component
{
    use WithFileUploads;
    public $tujuan, $idMat, $id_detMapel, $nama_materi, $file_materi, $content, $nav_dmid, $idMatr;
    public $tefm = false;
    public $telm = false;
    public $add = false, $edit = false;
    public $togglePage = false;
    public $countDM = 0;
    
    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }


    public function deleteMateri($idMatr)
    {
        $materi = Materi::find($idMatr);
        unlink('storage/content/' . $materi->file_materi);
        $materi->delete();
        return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
        session()->flash('pesan', 'Data berhasil dihapus');
    }

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $materi = DB::select('select m.nama_mapel, k.nama_kelas, dm.id as dmid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            where dm.id = ?', [$id]);
            return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    public function getMateri($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $materi = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid, 
            mat.nama_materi, mat.id as matid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            join materis as mat on mat.id_detMapel = dm.id
            where g.user_id = ?', [$id]);
            return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    //buat edit
    public function loadByID($idMatr)
    {
        $this->idMatr = $idMatr;
        $data = Materi::find($this->idMatr);
        // 'id_detMapel', 'nama_materi', 'desc_materi','content',
        $this->id_detMapel = $data['id_detMapel'];
        $this->nama_materi = $data['nama_materi'];
        $this->file_materi = $data['file_materi'];
        $this->content = $data['content'];
    }

    public function toogleModalAddEdit($act, $idMat)
    {
        $this->idMat = null;
        if ($act == 'add') {
            $this->add = true;
            $this->edit = false;
        } else if ($act == 'edit') {
            $this->add = false;
            $this->edit = true;
            if ($idMat > 0) {
                $this->idMatr = $idMat;
                $this->loadByID($this->idMatr);
            }
        }
    }

    public function reload()
    {
        return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getDetMap()
    {
        return DB::select('select * from detail_mapels');
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
        return view('livewire.guru.data-materi', [
            'dataMateri' => $this->getAll($this->nav_dmid),
            'dataMat' => $this->getMateri(Auth::user()->id),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataDetMap' => $this->getDetMap(Auth::user()->id),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

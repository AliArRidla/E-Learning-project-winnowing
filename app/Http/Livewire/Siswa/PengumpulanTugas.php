<?php

namespace App\Http\Livewire\Siswa;

use App\Models\NilaiTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class PengumpulanTugas extends Component
{
    use WithFileUploads;
    // 'id_tugas', 'id_siswa', 'file_tugas','content', 'nilai', 'waktu_pengumpulan',
    public $nav_dmid, $pData, $id_tgs, $file_tugas, $content, $nilai, $waktu_pengumpulan, $datenow;
    public $togglePage = false;

    public function getTgs()
    {
        if (Auth::user()->hasRole('siswa')) {
            $tugas = DB::select('select u.name, dm.id as dmid, t.nama_tugas, t.id as tid, t.file_tugas, t.content, t.tanggal, nt.id as ntid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join siswas as s on k.id = s.id_kelas
            join users as u on u.id = s.user_id
            join materis as mat on mat.id_detMapel = dm.id
            join tugas as t on t.id_materi = mat.id
            join nilai_tugas as nt on nt.id_tugas = t.id
            where t.id=? and s.user_id = ?', [$this->id_tgs, $id]);
            return $tugas;
        } else {
            return redirect(route('login'));
        }
    }
    
    public function mount($nav_dmid, $id_tgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_tgs = $id_tgs;
    }

    public function addKumpulTugas()
    {
        if (Auth::user()->hasRole('siswa')) {
            $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
            $this->sid = $ids[0]->id;
            $datenow = date('Y-m-d H:i:s');
            // dd($this->id_pres, $sid, $this->keterangan, $datenow);
            // 'id_tugas', 'id_siswa', 'file_tugas','content', 'nilai', 'waktu_pengumpulan',
            $val = $this->validate([
                'file_tugas' => 'required',
                'content' => 'required',
            ]);
            $file = $this->file_tugas->store('tugasSiswa', 'storage');

            if ($val) {
                $nt = NilaiTugas::create([
                    'id_tugas' => $this->id_tugas,
                    'id_siswa' => $this->sid,
                    'file_tugas' => $file,
                    'content' => $this->content,
                    'waktu_pengumpulan' => $datenow,
                ]);
                if ($nt) {
                    return redirect(route('dataMateri', ['nav_dmid' => $this->dmid]));
                    session()->flash('pesan', 'Data berhasil ditambah');
                } else {
                    return redirect(route('dataMateri', ['nav_dmid' => $this->dmid]));
                    session()->flash('pesan', 'Data GAGAL ditambah');
                }
            } else {
                return redirect(route('dataMateri', ['nav_dmid' => $this->dmid]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function updateKumpulTugas()
    {
        
    }

    public function getTugas($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $tgs = DB::select('select u.name, dm.id as dmid, t.nama_tugas, t.id as tid, t.file_tugas, t.content, t.tanggal
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join siswas as s on k.id = s.id_kelas
            join users as u on u.id = s.user_id
            join materis as mat on mat.id_detMapel = dm.id
            join tugas as t on t.id_materi = mat.id
            where t.id=? and s.user_id = ?', [$this->id_tgs, $id]);
            return $tgs;
        } else {
            return redirect(route('login'));
        }
    }

    public function download($id_tgs)
    {
        $tugas = Materi::findOrFail($id_tgs);
        $ft = $tugas->file_tugas;
        return response()->download(public_path('storage/file_tugas/' . $ft));
    }
    
    public function getPTugas($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select count(m.id) as cmid, dm.id as dmid, m.nama_mapel
            from materis as mat
            join detail_mapels as dm on mat.id_detMapel = dm.id
            join mapels as m on m.id = dm.id_mapel
            join kelas as k on dm.id_kelas = k.id
            join siswas as s on k.id = s.id_kelas
            where s.user_id = ? 
            group by dm.id, m.nama_mapel
            order by m.nama_mapel asc', [$id]);
            $this->pData = $data;
            return $data;
        } else {
            return redirect(route('login'));
        }
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
        return view('livewire.siswa.pengumpulan-tugas', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataTugas' => $this->getTugas(Auth::user()->id),
            'dataTgs' => $this->getTgs(Auth::user()->id),
        ])->layout('layouts.layapp', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

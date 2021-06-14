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
    public $nav_dmid, $pData, $id_tgs, $contentSiswa, $fileTgs_siswa, $nilai, $waktu_pengumpulan, $datenow;
    public $togglePage = false;
    public $id_nt;

    public function getTgs($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $tugas = DB::select('select u.name, dm.id as dmid, t.nama_tugas, t.id as tid, t.file_tugas, t.content, t.tanggal, nt.id as ntid,
            nt.fileTgs_siswa
            from nilai_tugas as nt
            join tugas as t on t.id = nt.id_tugas
            join materis as mat on mat.id = t.id_materi
            join detail_mapels as dm on dm.id = id_detMapel
            join kelas as k on k.id = dm.id_kelas
            join siswas as s on k.id = s.id_kelas
            join users as u on u.id = s.user_id
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

    
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function addKumpulTugas()
    {
        if (Auth::user()->hasRole('siswa')) {
            $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
            $this->sid = $ids[0]->id;
            // $datenow = date('Y-m-d H:i:s');
            // 'id_tugas', 'id_siswa', 'file_tugas','content', 'nilai', 'waktu_pengumpulan',
            $val = $this->validate([
                'fileTgs_siswa' => 'required',
            ]);
            $ori = $this->fileTgs_siswa->getClientOriginalName();
            $this->fsiswa = 'NilaiTugas' . uniqid() . $ori;
            $this->fileTgs_siswa->storeAs('tugas_siswa', $this->fsiswa, 'public');
            // dd($this->id_tgs, $this->sid, $this->contentSiswa, $this->fileTgs_siswa);
            if ($val) {
                $this->hydrate();
                $nt = NilaiTugas::create([
                    'id_tugas' => $this->id_tgs,
                    'id_siswa' => $this->sid,
                    'fileTgs_siswa' => $this->fsiswa,
                    'contentSiswa' => $this->contentSiswa,
                ]);
                if ($nt) {
                    return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data berhasil ditambah');
                } else {
                    return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data GAGAL ditambah');
                }
            } else {
                return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function loadByID($id_nt)
    {
        $this->id_nt = $id_nt;
        $data = NilaiTugas::find($this->id_nt);
        // dd($this->id_tgs, $this->sid, $this->contentSiswa, $this->fileTgs_siswa);
        $this->id_tgs = $data['id_tgs'];
        $this->sid = $data['sid'];
        $this->contentSiswa = $data['contentSiswa'];
        $this->fileTgs_siswa = $data['fileTgs_siswa'];
    }



    public function updateKumpulTugas()
    {
        if (Auth::user()->hasRole('siswa')) {
            $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
            $this->sid = $ids[0]->id;
            $nt = NilaiTugas::find($this->id_nt);

            $gambar_name = '';
            $gambar = $this->file('fileTgs_siswa');

            if ($gambar != '') {
                $this->validate([
                    'fileTgs_siswa' => 'required',
                ]);
                if ($gambar == true) {
                    unlink('storage/tugas_siswa/' . $nt->fileTgs_siswa);
                }
                $gambar_name = time() . "_" . $gambar->getClientOriginalName();
                $gambar->move(public_path('storage/tugas_siswa/'), $gambar_name);
            }
            $nt = NilaiTugas::find($this->id_nt)->update([
                'id_tugas' => $this->id_tgs,
                'id_siswa' => $this->sid,
                'fileTgs_siswa' => $this->gambar_name,
                'contentSiswa' => $this->contentSiswa,
            ]);
                
            if ($nt) {
                return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                session()->flash('pesan', 'Data berhasil ditambah');
            } else {
                return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function delTugas($id_tgs)
    {
        $tugasSis = NilaiTugas::find($id_tgs);
        unlink('storage/tugas_siswa/' . $tugasSis->fileTgs_siswa);
        $tugasSis->delete();
        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
        session()->flash('pesan', 'Data berhasil dihapus'); 
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
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

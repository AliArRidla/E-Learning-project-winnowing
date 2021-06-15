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
    public $id_nt, $extensi, $eror, $psn, $cek_nilai, $edit, $old_tugas, $del_psn = false;



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

        $siswa = $this->getAcc(Auth::user()->id);
        foreach ($siswa as $sis) {
            $this->id_sis = $sis->rid;
        }

        $this->cek_nilai = DB::select('select id from nilai_tugas 
                where id_tugas = ? and id_siswa = ?', [$this->id_tgs, $this->id_sis]);

        if ($this->cek_nilai != null) {
            //  $this->cek_nilai[0]->id;
            $edit = NilaiTugas::find($this->cek_nilai[0]->id);
            $this->old_tugas = $edit['fileTgs_siswa'];
            $this->contentSiswa = $edit['contentSiswa'];
            $this->id_nt = $edit['id'];
        }
    }

    // menghapus file tugas saja
    public function delFileTgsSis()
    {
        unlink('storage/tugas_siswa/' . $this->old_tugas);
        NilaiTugas::find($this->id_nt)->update([
            'fileTgs_siswa' => null,
        ]);
        $this->old_tugas = null;
        $this->del_psn = true;
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

            $val = $this->validate([
                'fileTgs_siswa' => 'required',
            ]);
            // $this->fsiswa = 'NilaiTugas' . uniqid() . $ori;
            // dd($this->id_tgs, $this->sid, $this->contentSiswa, $this->fileTgs_siswa);
            if ($this->fileTgs_siswa == null && $this->contentSiswa == null) {
                $this->eror = true;
                $this->psn = "Harus mengisi salah satu!";
            } else {
                if ($this->fileTgs_siswa != null) {
                    $ori = $this->fileTgs_siswa->getClientOriginalName();
                    $this->fname = uniqid() . '_Tugas_' . $ori;
                    $st = $this->fileTgs_siswa->storeAs('tugas_siswa', $this->fname, 'public');
                    if ($st) {
                        $ntg = NilaiTugas::create([
                            'id_tugas' => $this->id_tgs,
                            'id_siswa' => $this->sid,
                            'fileTgs_siswa' => $this->fname,
                            'contentSiswa' => $this->contentSiswa,
                        ]);
                    }
                }

                // $ntg = NilaiTugas::create([
                //     'id_tugas' => $this->id_tgs,
                //     'id_siswa' => $this->sid,
                //     'fileTgs_siswa' => $this->fname,
                //     'contentSiswa' => $this->contentSiswa,
                // ]);

                if ($ntg) {
                    session()->flash('pesan', 'Tugas berhasil ditambah');
                    return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                } else {
                    session()->flash('pesan', 'Tugas GAGAL ditambah');
                    return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function loadTgs()
    {
        // $this->id_nt = $id_nt;
        $data = NilaiTugas::find($this->id_nt);
        // dd($this->id_tgs, $this->sid, $this->contentSiswa, $this->fileTgs_siswa);
        // $this->id_tgs = $data['id_tgs'];
        // $this->sid = $data['sid'];
        $this->contentSiswa = $data['contentSiswa'];
        $this->fileTgs_siswa = $data['fileTgs_siswa'];
    }

    public function updateKumpulTugas()
    {
        if (Auth::user()->hasRole('siswa')) {
            $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
            $this->sid = $ids[0]->id;
            $nt = NilaiTugas::find($this->id_nt);

            if ($this->old_tugas == null && $this->fileTgs_siswa == null && $this->contentSiswa == null) {
                $this->eror = true;
                $this->psn = "Harus mengisi salah satu!";
            } else {
                if ($this->fileTgs_siswa == null) {
                    $this->hydrate();
                    $nt = NilaiTugas::find($this->id_nt)->update([
                        'contentSiswa' => $this->contentSiswa,
                    ]);
                    if ($nt) {
                        session()->flash('pesan', 'Tugas berhasil diubah');
                        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    } else {
                        session()->flash('pesan', 'Tugas GAGAL diubah');
                        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    }
                } else {
                    $this->hydrate();
                    $ori = $this->fileTgs_siswa->getClientOriginalName();
                    $this->ftugas = uniqid() . '_Tugas_' . $ori;
                    $this->fileTgs_siswa->storeAs('file-materi', $this->ftugas, 'public');
                    $nt = NilaiTugas::find($this->id_nt)->update([
                        'fileTgs_siswa' => $this->ftugas,
                        'contentSiswa' => $this->contentSiswa,
                    ]);
                    if ($nt) {
                        session()->flash('pesan', 'Tugas berhasil diubah');
                        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    } else {
                        session()->flash('pesan', 'Tugas GAGAL diubah');
                        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
                    }
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    //untuk mengahpus recordnya 
    public function delTugas()
    {
        $tugasSis = NilaiTugas::find($this->id_nt);
        unlink('storage/tugas_siswa/' . $tugasSis['fileTgs_siswa']);
        $tugasSis->delete();
        session()->flash('pesan', 'Data berhasil dihapus');
        return redirect(route('dataMateriSiswa', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getTugas($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $tgs = DB::select('select u.name, dm.id as dmid, t.nama_tugas, t.id as tid, t.file_tugas, 
            t.content, t.tanggal
            from tugas as t
            join materis as mat on mat.id = t.id_materi
            join detail_mapels as dm on dm.id = mat.id_detMapel
            join kelas as k on k.id = dm.id_kelas
            join siswas as s on k.id = s.id_kelas
            join users as u on u.id = s.user_id
            where t.id=? and s.user_id = ? ', [$this->id_tgs, $id]);
            return $tgs;
        } else {
            return redirect(route('login'));
        }
    }

    public function getPTugas()
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select nt.id, nt.created_at
            from nilai_tugas as nt
            where nt.id = ?', [$this->id_nt]);
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
            'dTgs' => $this->getPTugas($this->id_nt),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

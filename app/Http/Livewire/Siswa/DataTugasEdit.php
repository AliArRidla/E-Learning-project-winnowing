<?php

namespace App\Http\Livewire\Siswa;

use App\Models\NilaiTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTugasEdit extends Component
{

    use WithFileUploads;
    // 'id_tugas', 'id_siswa', 'fileTgs_siswa','contentSiswa', 'nilai',
    // public $nav_dmid, $pData, $id_tgs, $contentSiswa, $fileTgs_siswa, $nilai, $waktu_pengumpulan, $datenow;
    public $nav_dmid, $contentSiswa, $fileTgs_siswa, $old_file_tugas, $id_nt;
    public $nama_tugas, $eror, $psn, $cek_nilai, $id_tgs, $del_psn = false;

    public function mount($nav_dmid, $id_nt)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_nt = $id_nt;

        $siswa = $this->getAcc(Auth::user()->id);
        foreach ($siswa as $sis) {
            $this->id_sis = $sis->rid;
        }

        foreach ($mat as $m) {
            $this->nama_materi = $m->nama_materi;
        }

        $this->cek_nilai = DB::select('select count(*) as jml from nilai_tugas 
                where id = ? and id_siswa = ?', [$this->id_tgs, $this->id_sis]);

        $ntg = NilaiTugas::find($id_nt);
        $this->fileTgs_siswa = $ntg['fileTgs_siswa'];
        $this->contentSiswa = $ntg['contentSiswa'];
    }

    public function editKumpulTugas()
    {
        // dd($this->nama_materi, $this->file_materi, $this->old_file_materi, $this->content);

        if ($this->old_file_tugas == null && $this->fileTgs_siswa == null && $this->contentSiswa == null) {
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
                $this->ftugas = uniqid() . '_Tugas_' . $this->nama_mapel . '_' . $ori;
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
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function delFileTgsSis()
    {
        unlink('storage/tugas_siswa/' . $this->old_file_tugas);
        NilaiTugas::find($this->id_nt)->update([
            'fileTgs_siswa' => null,
        ]);
        $this->old_file_tugas = null;
        $this->del_psn = true;
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
        return $dMap;
    }

    public function render()
    {
        return view('livewire.siswa.data-tugas-edit', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

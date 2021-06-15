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
    public $nav_dmid, $id_tgs, $id_sis;
    public $nama_tugas, $file_tugas, $tanggal, $content_tugas;
    public $file_tgs_siswa, $old_tgs_siswa, $content_siswa, $id_nt, $nilai;
    public $extensi, $del_psn, $fname;

    public function mount($nav_dmid, $id_tgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_tgs = $id_tgs;

        $siswa = $this->getAcc(Auth::user()->id);
        foreach ($siswa as $sis) {
            $this->id_sis = $sis->rid;
        }

        $tgs = DB::select('select t.nama_tugas, t.file_tugas, t.content, t.tanggal
            from tugas as t
            join materis as mat on mat.id = t.id_materi
            where t.id = ?', [$id_tgs]);
        foreach ($tgs as $t) {
            $this->nama_tugas = $t->nama_tugas;
            $this->file_tugas  = $t->file_tugas;
            $this->content_tugas = $t->content;
            $this->tanggal = $t->tanggal;
        }

        $cek_nilai = DB::select('select id from nilai_tugas 
                where id_tugas = ? and id_siswa = ?', [$this->id_tgs, $this->id_sis]);

        if ($cek_nilai != null) {
            //  $this->cek_nilai[0]->id;
            $nt = NilaiTugas::find($cek_nilai[0]->id);
            $this->nilai = $nt['nilai'];
            $this->file_tgs_siswa = $nt['fileTgs_siswa'];
            $this->old_tgs_siswa = $nt['fileTgs_siswa'];
            $this->content_siswa = $nt['contentSiswa'];
            $this->id_nt = $nt['id'];
        }
    }

    protected $messages = [
        'file_tgs_siswa.required' => 'Mohon kirim Dokumen tugas Anda',
    ];

    public function saveTugasSiswa()
    {
        // dd($this->file_tgs_siswa, $this->content_siswa);
        $this->validate([
            'file_tgs_siswa' => 'required',
        ]);

        // if ($this->file_materi != null) {
        $ori = $this->file_tgs_siswa->getClientOriginalName();
        $this->fname = uniqid() . '_' . $ori;
        // }

        $cNT = NilaiTugas::create([
            'id_tugas' => $this->id_tgs,
            'id_siswa' => $this->id_sis,
            'fileTgs_siswa' => $this->fname,
            'contentSiswa' => $this->content_siswa,
        ]);

        if ($cNT) {
            $this->file_tgs_siswa->storeAs('tugas_siswa', $this->fname, 'public');
            session()->flash('pesan', 'Dokumen Tugas Anda berhasil diunggah');
            return redirect(route('tugasSiswa', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        } else {
            session()->flash('pesan', 'Dokumen Tugas GAGAL diunggah');
            return redirect(route('tugasSiswa', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        }
    }

    public function updateTugasSiswa()
    {
        $this->validate([
            'file_tgs_siswa' => 'required',
        ]);

        if ($this->file_tgs_siswa == null) {
            $this->fname = $this->old_tgs_siswa;
        } else {
            $ori = $this->file_tgs_siswa->getClientOriginalName();
            $this->fname = uniqid() . '_' . $ori;
        }

        $uNT = NilaiTugas::find($this->id_nt)->update([
            'id_tugas' => $this->id_tgs,
            'id_siswa' => $this->id_sis,
            'fileTgs_siswa' => $this->fname,
            'contentSiswa' => $this->content_siswa,
        ]);

        if ($uNT) {
            if ($this->file_tgs_siswa != null) {
                $this->file_tgs_siswa->storeAs('tugas_siswa', $this->fname, 'public');
            }
            session()->flash('pesan', 'Dokumen Tugas Anda berhasil diunggah');
            return redirect(route('tugasSiswa', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        } else {
            session()->flash('pesan', 'Dokumen Tugas GAGAL diunggah');
            return redirect(route('tugasSiswa', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        }
    }

    public function file_null()
    {
        $this->file_tgs_siswa = null;
        // return redirect(route('tugasSiswa', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
    }

    public function delFileTgs()
    {
        NilaiTugas::find($this->id_nt)->update([
            'fileTgs_siswa' => null,
        ]);
        unlink('storage/tugas_siswa/' . $this->old_tgs_siswa);
        $this->old_tgs_siswa = null;
        $this->file_tgs_siswa = null;
        $this->del_psn = true;
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
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

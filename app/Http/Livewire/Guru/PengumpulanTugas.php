<?php

namespace App\Http\Livewire\Guru;

use App\Models\NilaiTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PengumpulanTugas extends Component
{
    public $nav_dmid, $id_tgs, $nama_mapel, $nama_kelas, $keterangan;
    public $name, $contentSiswa, $fileTgs_siswa, $detNT, $nilai, $old_nilai;
    public $nama_tugas, $tanggal, $nama_materi, $file_tugas, $id_nt;

    protected $messages = [
        'nilai.required' => 'Mohon isi kolom nilai',
    ];

    public function mount($nav_dmid, $id_tgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_tgs = $id_tgs;

        $dtgs = DB::select('select t.nama_tugas, t.tanggal, m.nama_materi, t.file_tugas
                from tugas as t
                join materis as m on m.id = t.id_materi
                where t.id = ?', [$id_tgs]);
        foreach ($dtgs as $dt) {
            $this->nama_tugas = $dt->nama_tugas;
            $this->tanggal = $dt->tanggal;
            $this->nama_materi = $dt->nama_materi;
            $this->file_tugas = $dt->file_tugas;
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

    public function beriNilai()
    {
        $this->validate(['nilai' => 'required']);
        $n = NilaiTugas::find($this->id_nt)->update(['nilai' => $this->nilai]);
        if ($n) {
            session()->flash('pesan', 'Nilai untuk siswa ' . $this->name . ' berhasil ditambah');
            return redirect(route('dataPengumpulanTugasGuru', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        } else {
            session()->flash('pesan', 'Nilai untuk siswa ' . $this->name . ' GAGAL ditambah');
            return redirect(route('dataPengumpulanTugasGuru', ['nav_dmid' => $this->nav_dmid, 'id_tgs' => $this->id_tgs]));
        }
    }

    public function loadByID($id)
    {
        $this->detNT = DB::select('select u.name, nt.contentSiswa, nt.fileTgs_siswa, nt.nilai
        from nilai_tugas as nt
        join siswas as s on s.id = nt.id_siswa
        join users as u on u.id = s.user_id
        where nt.id = ?', [$id]);

        $this->id_nt = $id;

        foreach ($this->detNT as $dn) {
            $this->name = $dn->name;
            $this->contentSiswa = $dn->contentSiswa;
            $this->fileTgs_siswa = $dn->fileTgs_siswa;
            $this->nilai = $dn->nilai;
            $this->old_nilai = $dn->nilai;
        }
    }

    public function all_null()
    {
        $this->name = null;
        $this->contentSiswa = null;
        $this->fileTgs_siswa = null;
        $this->nilai = null;
    }


    public function getPengumpulan()
    {
        $tgs = DB::select('select nt.id as ntid, u.name, nt.created_at, nt.nilai
        from nilai_tugas as nt
        join siswas as s on s.id = nt.id_siswa
        join users as u on u.id = s.user_id
        where nt.id_tugas = ?', [$this->id_tgs]);
        return $tgs;
    }

    // public function getTugas($id_tgs)
    // {
    //     $tgs = DB::select('select t.nama_tugas, t.tanggal, m.nama_materi, t.file_tugas
    //     from tugas as t
    //     join materis as m on m.id = t.id_materi
    //     where t.id = ?', [$id_tgs]);

    //     return $tgs;
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
        return view('livewire.guru.pengumpulan-tugas', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataTugasSiswa' => $this->getPengumpulan(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

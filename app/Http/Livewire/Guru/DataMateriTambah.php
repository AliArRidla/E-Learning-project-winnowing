<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataMateriTambah extends Component
{
    use WithFileUploads;

    public $nav_dmid, $nama_materi, $content, $file_materi;
    public $nama_mapel, $nama_kelas, $eror, $psn, $extensi, $fname;

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

    public function saveMateri()
    {
        // dd($this->nama_materi, $this->file_materi, $this->content);
        // dd($this->file_materi->getClientOriginalName());
        $this->validate([
            'nama_materi' => 'required',
        ]);

        if ($this->file_materi == null && $this->content == null) {
            $this->eror = true;
            $this->psn = "Harus mengisi salah satu!";
        } else {
            if ($this->file_materi != null) {
                $ori = $this->file_materi->getClientOriginalName();
                $this->fname = uniqid() . '_Materi_' . $this->nama_mapel . '_' . $ori;
            }

            $cMat = Materi::create([
                'id_detMapel' => $this->nav_dmid,
                'nama_materi' => $this->nama_materi,
                'file_materi' => $this->fname,
                'content' => $this->content,
            ]);

            if ($cMat) {
                $this->file_materi->storeAs('file-materi', $this->fname, 'public');
                session()->flash('pesan', 'Materi berhasil ditambah');
                return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
            } else {
                session()->flash('pesan', 'Materi GAGAL ditambah');
                return redirect(route('dataMateri', ['nav_dmid' => $this->nav_dmid]));
            }
        }
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
        return view('livewire.guru.data-materi-tambah', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTugasEdit extends Component
{
    use WithFileUploads;
    public $nav_dmid, $nama_tugas, $ed_deskripsi, $file_tugas, $oldTugas;
    public $id_materi, $tanggal_dl, $waktu_dl, $deadline, $del_psn;
    public $nama_mapel, $nama_kelas, $eror, $extensi, $ftugas, $idTgs;

    protected $messages = [
        'id_materi.required' => 'Mohon pilih materi',
        'nama_tugas.required' => 'Mohon isi kolom Judul Tugas.',
        'tanggal_dl.required' => 'Mohon isi kolom Tanggal tugas berakhir.',
    ];

    public function mount($nav_dmid, $idTgs)
    {
        $this->nav_dmid = $nav_dmid;
        $this->idTgs = $idTgs;

        $dm = DB::select('select m.nama_mapel, k.nama_kelas
        from detail_mapels as dm
        join mapels as m on dm.id_mapel = m.id
        join kelas as k on dm.id_kelas = k.id
        where dm.id = ?', [$nav_dmid]);

        foreach ($dm as $d) {
            $this->nama_mapel = $d->nama_mapel;
            $this->nama_kelas = $d->nama_kelas;
        }

        $tgs = Tugas::find($idTgs);
        $this->id_materi = $tgs['id_materi'];
        $this->nama_tugas = $tgs['nama_tugas'];
        $this->ed_deskripsi = $tgs['content'];
        $this->oldTugas = $tgs['file_tugas'];
        $this->tanggal = $tgs['tanggal'];

        $this->tanggal_dl = date('Y-m-d', strtotime($this->tanggal));
    }

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $tugas = DB::select('select m.id as mid, m.nama_materi, dm.id as dmid
                from materis as m
                join detail_mapels as dm on dm.id = m.id_detMapel
                WHERE dm.id = ?', [$id]);
            return $tugas;
        } else {
            return redirect(route('login'));
        }
    }

    public function editTugas()
    {
        $this->validate([
            'id_materi' => 'required',
            'nama_tugas' => 'required',
            'tanggal_dl' => 'required',
        ]);

        $this->deadline = $this->tanggal_dl . ' ' . $this->waktu_dl;

        $mtr = Materi::find($this->id_materi);
        $this->nama_materi = $mtr['nama_materi'];
        // dd($this->nama_materi, $this->file_materi, $this->old_file_materi, $this->deskripsi);

        if ($this->oldTugas == null && $this->file_tugas == null && $this->ed_deskripsi == null) {
            $this->eror = true;
            // $this->psn = "Harus mengisi salah satu!";
        } else {
            if ($this->file_tugas == null) {
                $this->hydrate();
                $tgs = Tugas::find($this->idTgs)->update([
                    'id_materi' => $this->id_materi,
                    'nama_tugas' => $this->nama_tugas,
                    'content' => $this->ed_deskripsi,
                    'tanggal' => $this->deadline,
                ]);
                if ($tgs) {
                    session()->flash('pesan', 'Tugas berhasil diubah');
                    return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
                } else {
                    session()->flash('pesan', 'Tugas GAGAL diubah');
                    return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
                }
            } else {
                $this->hydrate();
                $ori = $this->file_tugas->getClientOriginalName();
                $this->ftugas = uniqid() . '_Tugas_' . $this->nama_materi . '_' . $ori;
                $this->file_tugas->storeAs('file_tugas', $this->ftugas, 'public');
                $tgs = Tugas::find($this->idTgs)->update([
                    'id_materi' => $this->id_materi,
                    'nama_tugas' => $this->nama_tugas,
                    'file_tugas' => $this->ftugas,
                    'content' => $this->ed_deskripsi,
                    'tanggal' => $this->deadline,
                ]);
                if ($tgs) {
                    session()->flash('pesan', 'Tugas berhasil diubah');
                    return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
                } else {
                    session()->flash('pesan', 'Tugas GAGAL diubah');
                    return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
                }
            }
        }
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function file_null()
    {
        $this->file_tugas = null;
    }

    public function delFileTgs()
    {
        Tugas::find($this->idTgs)->update([
            'file_tugas' => null,
        ]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/storage/public/file_tugas/' . $this->oldTugas);
        $this->oldTugas = null;
        $this->del_psn = true;
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
        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.data-tugas-edit', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'tugas' => $this->getAll($this->nav_dmid),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layapp', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

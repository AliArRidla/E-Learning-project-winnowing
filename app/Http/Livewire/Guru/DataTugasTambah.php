<?php

namespace App\Http\Livewire\Guru;

use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTugasTambah extends Component
{
    // 'id_materi', 'nama_tugas', 'deskripsi', 'file_tugas', 'tanggal',
    use WithFileUploads;
    public $nav_dmid, $nama_tugas, $deskripsi, $file_tugas;
    public $id_materi, $tanggal_dl, $waktu_dl, $deadline;
    public $nama_mapel, $nama_kelas, $eror, $extn, $ftugas;

    protected $messages = [
        'id_materi.required' => 'Mohon pilih materi',
        'nama_tugas.required' => 'Mohon isi Nama Tugas.',
        'tanggal_dl.required' => 'Mohon isi Tanggal tugas berakhir.',
    ];

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

    public function getAll($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $tugas = DB::select('select m.id as mid, m.nama_materi, dm.id as dmid 
                from materis as m
                join detail_mapels as dm on dm.id = m.id_detMapel
                WHERE dm.id=?', [$id]);
            return $tugas;
        } else {
            return redirect(route('login'));
        }
    }

    public function saveTugas()
    {
        $this->validate([
            'id_materi' => 'required',
            'nama_tugas' => 'required',
            'tanggal_dl' => 'required',
            'waktu_dl' => 'required'
        ]);

        $mtr = Materi::find($this->id_materi);
        $this->nama_materi = $mtr['nama_materi'];

        if ($this->file_tugas == null && $this->deskripsi == null) {
            $this->eror = true;
            // $this->psn = "Mohon isi unggah File ATAU isi Deskripsi Tugas.";
        } else {
            $this->eror = false;
            if ($this->file_tugas != null) {
                $ori = $this->file_tugas->getClientOriginalName();
                $this->ftugas = uniqid() . '_Tugas_' . $this->nama_tugas . '_' . $ori;
            }

            $this->deadline = $this->tanggal_dl . ' ' . $this->waktu_dl;
            // dd($this->deskripsi, $this->ftugas);
            $tgs = Tugas::create([
                'id_materi' => $this->id_materi,
                'nama_tugas' => $this->nama_tugas,
                'file_tugas' => $this->ftugas,
                'content' => $this->deskripsi,
                'tanggal' => $this->deadline,
            ]);

            if ($tgs) {
                $this->file_tugas->storeAs('file_tugas', $this->ftugas, 'public');
                session()->flash('pesan', 'Tugas berhasil ditambah');
                return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
            } else {
                session()->flash('pesan', 'Tugas GAGAL ditambah');
                return redirect(route('dataTugas', ['nav_dmid' => $this->nav_dmid]));
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
        return view('livewire.guru.data-tugas-tambah', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'tugas' => $this->getAll($this->nav_dmid),
            'getDMapGuru' => $this->getDMap(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

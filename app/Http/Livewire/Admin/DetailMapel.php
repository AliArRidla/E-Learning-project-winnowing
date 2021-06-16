<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetailMapel as ModelsDetailMapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class DetailMapel extends Component
{
    public $id_mapel, $id_dm, $nama_mapel, $nama_kelas, $name, $id_kelas, $id_guru;

    protected $messages = [
        'id_mapel.required' => 'Mohon pilih mata pelajaran',
        'id_kelas.required' => 'Mohon pilih kelas',
        'id_guru.required' => 'Mohon pilih guru',
    ];

    public function tambahDM()
    {
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_guru' => 'required',
        ]);

        $crDM = ModelsDetailMapel::create([
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
            'id_guru' => $this->id_guru,
        ]);

        if ($crDM) {
            session()->flash('pesan', 'Detail Mapel berhasil ditambah');
            return redirect(route('detailMapel'));
        } else {
            session()->flash('pesan', 'Detail Mapel GAGAL ditambah');
            return redirect(route('detailMapel'));
        }
    }

    public function editDM()
    {
        $this->validate([
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_guru' => 'required',
        ]);

        $uDM = ModelsDetailMapel::find($this->id_dm)->update([
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
            'id_guru' => $this->id_guru,
        ]);

        if ($uDM) {
            session()->flash('pesan', 'Detail Mapel berhasil diubah');
            return redirect(route('detailMapel'));
        } else {
            session()->flash('pesan', 'Detail Mapel GAGAL diubah');
            return redirect(route('detailMapel'));
        }
    }

    public function loadByID($dmid)
    {
        $this->id_dm = $dmid;
        $detDM = DB::select('select m.id as mid, k.id as kid, 
        m.nama_mapel, k.nama_kelas, u.name, g.id as gid
        from detail_mapels as dm
        join kelas as k on k.id = dm.id_kelas
        join mapels as m on m.id = dm.id_mapel
        join gurus as g on g.id = dm.id_guru
        join users as u on u.id = g.user_id
        where dm.id = ?', [$this->id_dm]);

        foreach ($detDM as $d) {
            $this->nama_kelas = $d->nama_kelas;
            $this->nama_mapel = $d->nama_mapel;
            $this->name = $d->name;
            $this->id_mapel = $d->mid;
            $this->id_kelas = $d->kid;
            $this->id_guru = $d->gid;
        }
    }

    public function deleteDM()
    {
        $del = ModelsDetailMapel::find($this->id_dm);
        $del->delete();
        session()->flash('pesan', 'Detail Mapel berhasil dihapus');
        return redirect(route('detailMapel'));
    }

    public function getDM()
    {
        return DB::select('select dm.id, m.nama_mapel, k.nama_kelas, u.name 
        from detail_mapels as dm
        join mapels as m on m.id = dm.id_mapel
        join kelas as k on k.id = dm.id_kelas
        join gurus as g on g.id = dm.id_guru
        join users as u on u.id = g.user_id
        order by k.nama_kelas, m.nama_mapel asc');
    }

    public function clearAll()
    {
        $this->id_dm = null;
        $this->id_kelas = null;
        $this->id_guru = null;
        $this->id_mapel = null;
    }

    public function getMapel()
    {
        return DB::select('select id, nama_mapel from mapels order by nama_mapel asc');
    }

    public function getKelas()
    {
        return DB::select('select id, nama_kelas from kelas order by nama_kelas asc');
    }

    public function getGuru()
    {
        return DB::select('select g.id as gid, u.name from gurus as g
        join users as u on u.id = g.user_id order by u.name asc');
    }

    public function cekJurusan()
    {
        $cek = DB::table('jurusans')->count();
        return $cek;
    }
    public function cekDaftarMapel()
    {
        $cek = DB::table('mapels')->count();
        return $cek;
    }

    public function countKelas()
    {
        $jmlKelas = DB::table('kelas')->count();
        // dd($jmlGuru);
        return $jmlKelas;
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        } else if (Auth::user()->hasRole('admin')) {
            $data = DB::select('select a.id as rid, a.user_id as uid, a.foto
            from admins as a
            join users as u on u.id = a.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.detail-mapel', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMapel' => $this->getMapel(),
            'dataKelas' => $this->getKelas(),
            'dataGuru' => $this->getGuru(),
            'dataDM' => $this->getDM(),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

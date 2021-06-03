<?php

namespace App\Http\Livewire\Guru;

use App\Models\DetailPresensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListPresensi extends Component
{
    public $id_pres, $countDM, $sid, $dpid, $keterangan;

    public function mount($id_pres)
    {
        $this->id_pres = $id_pres;
    }

    public function loadData($sid, $dpid)
    {
        if (Auth::user()->hasRole('guru')) {
            $this->sid = $sid;
            $this->dpid = $dpid;
        } else {
            return redirect(route('login'));
        }
    }

    public function updateDetPres()
    {
        $datenow = date('Y-m-d H:i');
        $val = $this->validate([
            'keterangan' => 'required',
        ]);

        if ($val) {
            // $map = Mapel::find($this->mid)->update(['nama_mapel' => $this->nama_mapel]);
            $cpres = DetailPresensi::find($this->dpid)->update([
                // 'id_presensi' => $this->id_pres,
                // 'id_siswa' => $this->sid,
                'keterangan' => $this->keterangan,
                'waktu_absen' => $datenow,
            ]);
            if ($cpres) {
                return redirect(route('listPresensiGuru', ['id_pres' => $this->id_pres]));
                session()->flash('pesan', 'Data berhasil ditambah');
            } else {
                return redirect(route('listPresensiGuru', ['id_pres' => $this->id_pres]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('listPresensiGuru', ['id_pres' => $this->id_pres]));
            session()->flash('pesan', 'Data GAGAL ditambah');
        }
    }

    public function getPres()
    {
        $pres = DB::select('select m.nama_mapel, k.nama_kelas 
        from presensis as p
        join detail_mapels as dm on p.id_det_mapel = dm.id
        join mapels as m on m.id = dm.id_mapel
        join kelas as k on dm.id_kelas = k.id
        where p.id = ?', [$this->id_pres]);

        return $pres;
    }

    public function getDetPres()
    {
        if (Auth::user()->hasRole('guru')) {
            $dPres = DB::select('select dp.id as dpid, u.name, 
            dp.keterangan, dp.waktu_absen, s.id as sid
            from detail_presensis as dp
            join siswas as s on s.id = dp.id_siswa
            join users as u on u.id = s.user_id
            where id_presensi = ?', [$this->id_pres]);

            return $dPres;
        } else {
            return redirect(route('login'));
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

    public function countMapel()
    {
        $dataGuru = DB::select('select * from gurus where user_id = ?', [Auth::user()->id]);
        foreach ($dataGuru as $key) {
            $idg = $key->id;
        }

        $jmlMapel = DB::select(
            'select COUNT(*) AS jml FROM (
                SELECT mapels.nama_mapel FROM detail_mapels 
                JOIN mapels ON detail_mapels.id_mapel = mapels.id 
                WHERE detail_mapels.id_guru = ? 
                GROUP BY mapels.nama_mapel
            ) jml',
            [$idg]
        );

        // select COUNT(*) AS jml FROM ( SELECT kelas.nama_kelas FROM detail_mapels JOIN kelas ON detail_mapels.id_kelas = kelas.id WHERE detail_mapels.id_guru = 4 GROUP BY detail_mapels.id_kelas ) jml

        foreach ($jmlMapel as $key) {
            $jmlMap = $key->jml;
        }

        return $jmlMap;
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

        foreach ($dMap as $k) {
            $this->countDM++;
        }

        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.list-presensi', [
            'jmlMapel' => $this->countMapel(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataDetPres' => $this->getDetPres(),
            'dataPres' => $this->getPres(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

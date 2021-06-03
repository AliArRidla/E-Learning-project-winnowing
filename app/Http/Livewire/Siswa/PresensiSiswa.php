<?php

namespace App\Http\Livewire\Siswa;

use App\Models\DetailPresensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PresensiSiswa extends Component
{
    public $id_pres, $cdata = 0, $keterangan, $sid;

    public function mount($id_pres)
    {
        $this->id_pres = $id_pres;
    }

    public function addPresensi()
    {
        if (Auth::user()->hasRole('siswa')) {
            $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
            $this->sid = $ids[0]->id;
            $datenow = date('Y-m-d H:i');
            // dd($this->id_pres, $sid, $this->keterangan, $datenow);
            $val = $this->validate([
                'keterangan' => 'required',
            ]);

            if ($val) {
                $cpres = DetailPresensi::create([
                    'id_presensi' => $this->id_pres,
                    'id_siswa' => $this->sid,
                    'keterangan' => $this->keterangan,
                    'waktu_absen' => $datenow,
                ]);
                if ($cpres) {
                    return redirect(route('presensiSiswa', ['id_pres' => $this->id_pres]));
                    session()->flash('pesan', 'Data berhasil ditambah');
                } else {
                    return redirect(route('presensiSiswa', ['id_pres' => $this->id_pres]));
                    session()->flash('pesan', 'Data GAGAL ditambah');
                }
            } else {
                return redirect(route('presensiSiswa', ['id_pres' => $this->id_pres]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function getAbsen($id)
    {
        if (Auth::user()->hasRole('siswa')) {
            $data = DB::select('select p.id as pid, u.id as uid, s.id as sid, u.name, p.hari_absen, p.waktu_mulai,
                p.waktu_selesai, m.nama_mapel, p.jangka_waktu, k.nama_kelas
                from presensis as p
                join detail_mapels as dm on p.id_det_mapel = dm.id
                join mapels as m on m.id = dm.id_mapel
                join kelas as k on dm.id_kelas = k.id
                join siswas as s on k.id = s.id_kelas
                join users as u on u.id = s.user_id
                where p.id = ? and s.user_id = ?', [$this->id_pres, $id]);
            // foreach ($data as $k) {
            //     $this->cdata++;
            // }
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
        return view('livewire.siswa.presensi-siswa', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataAbsen' => $this->getAbsen(Auth::user()->id),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

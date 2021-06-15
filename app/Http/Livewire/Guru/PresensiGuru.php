<?php

namespace App\Http\Livewire\Guru;

use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PresensiGuru extends Component
{
    public $tujuan, $twaktu_mulai, $twaktu_selesai, $tgl_absen, $jangka_waktu, $nav_dmid, $pid;
    public $msg = '', $sama = false;
    public $nama_mapel, $nama_kelas, $hari_absen;

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }

    public function ddMe()
    {
        dd($this->tujuan, $this->tgl_absen, $this->twaktu_mulai, $this->twaktu_selesai, $this->jangka_waktu);
    }

    public function createPresensi()
    {
        if (Auth::user()->hasRole('guru')) {
            $this->validate([
                'tujuan' => 'required',
                'tgl_absen' => 'required',
                'twaktu_mulai' => 'required',
                'twaktu_selesai' => 'required',
                'jangka_waktu' => 'required',
            ]);

            if ($this->twaktu_mulai >= $this->twaktu_selesai) {
                $this->hydrate();
                $this->sama = true;
                if ($this->twaktu_mulai == $this->twaktu_selesai) {
                    $this->msg = "Waktu Mulai dan Waktu Selesai tidak boleh sama!";
                } else if ($this->twaktu_mulai > $this->twaktu_selesai) {
                    $this->msg = "Waktu Selesai tidak boleh lebih kecil dari waktu mulai!";
                }
            } else {
                $this->hydrate();
                $this->msg = "";
                $this->sama = false;
                $cpres = Presensi::create([
                    'id_det_mapel' => $this->tujuan,
                    'hari_absen' => $this->tgl_absen,
                    'waktu_mulai' => $this->twaktu_mulai,
                    'waktu_selesai' => $this->twaktu_selesai,
                    'jangka_waktu' => $this->jangka_waktu,
                ]);

                if ($cpres) {
                    return redirect(route('presensiGuru', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data berhasil ditambah');
                } else {
                    return redirect(route('presensiGuru', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data GAGAL ditambah');
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function saveID($pid)
    {
        $this->pid = $pid;
        $data = DB::select('select p.id as pid, p.id_det_mapel as pidm, p.jangka_waktu,
            k.nama_kelas, m.nama_mapel, p.hari_absen, p.waktu_mulai, p.waktu_selesai
            from presensis as p
            join detail_mapels as dm on dm.id = p.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where p.id = ?', [$this->pid]);
        foreach ($data as $k) {
            $this->nama_kelas = $k->nama_kelas;
            $this->nama_mapel = $k->nama_mapel;
            $pday = date('D', strtotime($k->hari_absen));
            switch ($pday) {
                case 'Sun':
                    $hari_ini = "Minggu";
                    break;

                case 'Mon':
                    $hari_ini = "Senin";
                    break;

                case 'Tue':
                    $hari_ini = "Selasa";
                    break;

                case 'Wed':
                    $hari_ini = "Rabu";
                    break;

                case 'Thu':
                    $hari_ini = "Kamis";
                    break;

                case 'Fri':
                    $hari_ini = "Jumat";
                    break;

                case 'Sat':
                    $hari_ini = "Sabtu";
                    break;

                default:
                    $hari_ini = "Tidak di ketahui";
                    break;
            }
            $this->hari_absen = $hari_ini;
        }
    }

    public function delPres()
    {
        $delPres = Presensi::find($this->pid);
        // dd($delMapel);
        $delPres->delete();
        session()->flash('pesan', 'Data berhasil dihapus');
        return redirect(route('presensiGuru', ['nav_dmid' => $this->nav_dmid]));
    }

    public function getMapel()
    {
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select dm.id as dmid, k.nama_kelas, m.nama_mapel
            from detail_mapels as dm
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where dm.id = ?', [$this->nav_dmid]);
            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getPresensis()
    {
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select p.id as pid, p.id_det_mapel as pidm, p.jangka_waktu,
            k.nama_kelas, m.nama_mapel, p.hari_absen, p.waktu_mulai, p.waktu_selesai
            from presensis as p
            join detail_mapels as dm on dm.id = p.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where p.id_det_mapel = ?', [$this->nav_dmid]);
            return $data;
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

    public function loadName()
    {
        $dMap = DB::select(
            'select dm.id as dmid, m.nama_mapel, k.nama_kelas 
            from detail_mapels as dm
            join mapels as m on dm.id_mapel = m.id
            join kelas as k on dm.id_kelas = k.id
            where dm.id = ?',
            [$this->nav_dmid]
        );
        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.presensi-guru', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMapel' => $this->getMapel(),
            'dataAbsen' => $this->getPresensis(),
            'loadName' => $this->loadName(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

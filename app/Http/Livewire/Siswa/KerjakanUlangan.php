<?php

namespace App\Http\Livewire\Siswa;

use App\Models\NilaiUlangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class KerjakanUlangan extends Component
{
    public $nav_dmid, $id_ul, $is_poin, $id_siswa, $poinNow, $benar, $salah;
    public $soal, $pilihan_a, $pilihan_b, $pilihan_c, $pilihan_d, $pilihan_e;
    public $tgl_ulangan, $waktu_selesai;
    public $pilihan = [];
    public $id_soal = [];
    public $poin = [];

    public function mount($nav_dmid, $id_ul)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_ul = $id_ul;

        $dUl = DB::select('select is_poin, tgl_ulangan, waktu_selesai
        from ulangans where id = ?', [$this->id_ul]);
        foreach ($dUl as $l) {
            $this->is_poin = $l->is_poin;
            $this->tgl_ulangan = $l->tgl_ulangan;
            $this->waktu_selesai = $l->waktu_selesai;
        }

        $dSo = DB::select('select * from soals where id_ulangan = ?', [$this->id_ul]);
        foreach ($dSo as $d) {
            array_push($this->id_soal, $d->id);
            if ($this->is_poin == 1 || $this->is_poin == '1') {
                array_push($this->poin, $d->poin);
            }
        }

        $dSis = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
        $this->id_siswa = $dSis[0]->id;
    }

    public function simpanJawaban()
    {
        // $i = 0;
        // dd($this->pilihan[$i + 1]);
        $this->benar = 0;
        $this->salah = 0;
        $this->poinNow = 0;
        for ($i = 0; $i < count($this->pilihan); $i++) {
            $j = $i + 1;
            $jawaban = $this->pilihan[$j];
            $ids = $this->id_soal[$i];
            $cekJawaban = DB::table('soals')
                ->where('id', '=', $ids)
                ->where('kunci_jawaban', '=', $jawaban)
                ->count();
            if ($cekJawaban != null) {
                if ($this->poin != null) {
                    $this->poinNow += $this->poin[$i];
                }
                ++$this->benar;
            } else {
                ++$this->salah;
            }
        }

        if ($this->poin == null) {
            $nilai = 100 / count($this->id_soal) * $this->benar;
            $this->poinNow = number_format($nilai, 2, ',', '');
        }
        // dd($benar, $salah, $poinNow, $this->id_siswa);
        $cNilai = NilaiUlangan::create([
            'id_siswa' => $this->id_siswa,
            'id_ulangan' => $this->id_ul,
            'nilai' => $this->poinNow,
            'benar' => $this->benar,
            'salah' => $this->salah,
        ]);

        if ($cNilai) {
            session()->flash('pesan', 'Anda telah berhasil melakukan ujian');
            return redirect(route('ulanganSiswa', ['nav_dmid' => $this->nav_dmid]));
        } else {
            session()->flash('pesan', 'Ujian GAGAL! Segera hubungi guru Anda!');
            return redirect(route('ulanganSiswa', ['nav_dmid' => $this->nav_dmid]));
        }
    }

    public function getUl()
    {
        $data = DB::select('select ul.id as id_ul, ul.judul_ulangan,
        m.nama_mapel, k.nama_kelas
        from ulangans as ul
        join detail_mapels as dm on dm.id = ul.id_det_mapel
        join kelas as k on dm.id_kelas = k.id
        join mapels as m on dm.id_mapel = m.id
        where ul.id = ?', [$this->id_ul]);
        return $data;
    }

    public function getSoals()
    {
        $data = DB::select('select * from soals where id_ulangan = ?', [$this->id_ul]);
        // foreach ($data as $d) {
        //     array_push($this->id_soal, $d->id);
        // }
        return $data;
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
        return view('livewire.siswa.kerjakan-ulangan', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUl(),
            'dataSoal' => $this->getSoals(),
        ])->layout('layouts.layt', [
            'getNavMapSiswa' => $this->getNavMap(),
        ]);
    }
}

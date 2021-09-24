<?php

namespace App\Http\Livewire\Guru;

use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TambahUlangan extends Component
{
    public $tujuan, $twaktu_mulai, $twaktu_selesai, $tgl_ulangan, $nav_dmid, $ulid, $is_poin = false, $judul_ulangan;
    public $msg = '', $sama = false, $jmlSoal;
    public $nama_mapel, $nama_kelas, $dmjudul_ulangan, $dmtgl_ulangan;
    public $emjudul_ulangan, $emtgl_ulangan, $emtwaktu_mulai, $emtwaktu_selesai;
    public $emmsg = '', $emsama = false;
    
    protected $messages = [
        'judul_ulangan.required' => 'Mohon isi kolom Judul Ulangan',
        'twaktu_mulai.required' => 'Mohon isi kolom Waktu Ulangan Dimulai.',
        'twaktu_selesai.required' => 'Mohon isi kolom Waktu Ulangan Selesai.',
        'tgl_ulangan.required' => 'Mohon isi Tanggal Ulangan dimulai.',
        'emjudul_ulangan.required' => 'Mohon isi kolom Judul Ulangan',
        'emtwaktu_mulai.required' => 'Mohon isi kolom Waktu Ulangan Dimulai.',
        'emtwaktu_selesai.required' => 'Mohon isi kolom Waktu Ulangan Selesai.',
        'emtgl_ulangan.required' => 'Mohon isi Tanggal Ulangan dimulai.',
    ];

    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }

    public function createUlangan()
    {
        if (Auth::user()->hasRole('guru')) {
            $this->validate([
                'tujuan' => 'required',
                'judul_ulangan' => 'required',
                'tgl_ulangan' => 'required',
                'twaktu_mulai' => 'required',
                'twaktu_selesai' => 'required',
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
                $ipoin = $this->is_poin == false ? '0' : '1';
                // dd($this->tujuan, $this->judul_ulangan, $this->tgl_ulangan, $this->twaktu_mulai, $this->twaktu_selesai, $ipoin);

                $cpres = Ulangan::create([
                    'id_det_mapel' => $this->tujuan,
                    'judul_ulangan' => $this->judul_ulangan,
                    'tgl_ulangan' => $this->tgl_ulangan,
                    'waktu_mulai' => $this->twaktu_mulai,
                    'waktu_selesai' => $this->twaktu_selesai,
                    'is_poin' => $ipoin,
                ]);

                if ($cpres) {
                    return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data berhasil ditambah');
                } else {
                    return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
                    session()->flash('pesan', 'Data GAGAL ditambah');
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function saveID($ulid)
    {
        $this->ulid = $ulid;
        $data = DB::select('select ul.id as ulid, ul.id_det_mapel as ulidm, ul.judul_ulangan,
            k.nama_kelas, m.nama_mapel, ul.tgl_ulangan, ul.waktu_mulai, ul.waktu_selesai
            from ulangans as ul
            join detail_mapels as dm on dm.id = ul.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where ul.id = ?', [$this->ulid]);
        foreach ($data as $k) {
            $this->nama_kelas = $k->nama_kelas;
            $this->nama_mapel = $k->nama_mapel;
            $this->dmjudul_ulangan = $k->judul_ulangan;
            $this->dmtgl_ulangan = $k->tgl_ulangan;
            $this->emjudul_ulangan = $k->judul_ulangan;
            $this->emtgl_ulangan = $k->tgl_ulangan;
            // $t = date('H:i', strtotime($k->waktu_mulai));
            // $this->emtwaktu_mulai = $t;
            // $this->emtwaktu_selesai = $k->waktu_selesai;
        }
    }

    public function allNull()
    {
        $this->ulid = null;
        $this->emjudul_ulangan = null;
        $this->emtgl_ulangan = null;
    }

    public function editUl($ulid)
    {
        if ($this->emtwaktu_mulai >= $this->emtwaktu_selesai) {
            $this->hydrate();
            $this->emsama = true;
            if ($this->emtwaktu_mulai == $this->emtwaktu_selesai) {
                $this->emmsg = "Waktu Mulai dan Waktu Selesai tidak boleh sama!";
            } else if ($this->emtwaktu_mulai > $this->emtwaktu_selesai) {
                $this->emmsg = "Waktu Selesai tidak boleh lebih kecil dari waktu mulai!";
            }
        } else {
            $this->hydrate();
            $this->emmsg = "";
            $this->emsama = false;
            // dd($ulid, $this->emjudul_ulangan, $this->emtgl_ulangan, $this->emtwaktu_mulai, $this->emtwaktu_selesai);
            
            $this->validate([
                'emjudul_ulangan' => 'required',
                'emtgl_ulangan' => 'required',
                'emtwaktu_mulai' => 'required',
                'emtwaktu_selesai' => 'required',
            ]);
            
            $eUl = Ulangan::find($ulid)->update([
                // 'id_det_mapel' => $this->tujuan,
                'judul_ulangan' => $this->emjudul_ulangan,
                'tgl_ulangan' => $this->emtgl_ulangan,
                'waktu_mulai' => $this->emtwaktu_mulai,
                'waktu_selesai' => $this->emtwaktu_selesai,
            ]);

            if ($eUl) {
                return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
                session()->flash('pesan', 'Data berhasil diubah');
            } else {
                return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
                session()->flash('pesan', 'Data GAGAL ditambah');
            }
        }
    }

    public function delUl()
    {
        $delUl = Ulangan::find($this->ulid);
        // dd($delUl);
        $delUl->delete();
        return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
        session()->flash('msg', 'Data berhasil dihapus');
    }

    public function reload()
    {
        return redirect(route('ulanganGuru', ['nav_dmid' => $this->nav_dmid]));
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    // public function cekSoal($id_ul)
    // {
    //     $jmlSoal = DB::select(
    //         'select COUNT(*) AS jml FROM (
    //             SELECT soals.id FROM soals
    //             JOIN ulangans ON soals.id_ulangan = ulangans.id
    //             WHERE soals.id_ulangan = ?
    //         ) jml',
    //         [$id_ul]
    //     );

    //     $no_soal = 1;

    //     if (intval($jmlSoal[0]->jml) > 0) {
    //         $no_soal = intval($jmlSoal[0]->jml) + 1;
    //     }

    //     return $no_soal;
    // }

    public function getUlangan()
    {
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select ul.id as ulid, ul.id_det_mapel as ulidm, ul.judul_ulangan,
            k.nama_kelas, m.nama_mapel, ul.tgl_ulangan, ul.waktu_mulai, ul.waktu_selesai, ul.is_poin
            from ulangans as ul
            join detail_mapels as dm on dm.id = ul.id_det_mapel
            join kelas as k on dm.id_kelas = k.id
            join mapels as m on dm.id_mapel = m.id
            where ul.id_det_mapel = ?', [$this->nav_dmid]);

            // foreach ($data as $d) {
            //     $this->jmlSoal = DB::select(
            //         'select COUNT(*) AS jml FROM (
            //             SELECT soals.id FROM soals
            //             JOIN ulangans ON soals.id_ulangan = ulangans.id
            //             WHERE soals.id_ulangan = ?
            //         ) jml',
            //         [$d->ulid]
            //     );
            // }

            return $data;
        } else {
            return redirect(route('login'));
        }
    }

    // public function ddMee()
    // {
    //     dd($this->jmlSoal);
    // }

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

        // foreach ($dMap as $k) {
        //     $this->countDM++;
        // }

        return $dMap;
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

    public function render()
    {
        return view('livewire.guru.tambah-ulangan', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataMapel' => $this->getMapel(),
            'dataUl' => $this->getUlangan(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

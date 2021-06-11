<?php

namespace App\Http\Livewire\Guru;

use App\Models\Soal;
use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class SoalUlangan extends Component
{
    use WithFileUploads;

    // public $id_ul, $pilgan, $intPoin;
    public $id_ul, $ed_soal, $pilA, $pilB, $pilC, $pilD, $pilE, $poin, $kunci_jawaban;
    // public $nav_dmid;

    public function mount($id_ul)
    {
        $this->id_ul = $id_ul;
        // $this->nav_dmid = $nav_dmid;
    }

    public function saveSoal()
    {
        $pn = $this->getUlangan($this->id_ul);
        if ($pn['is_poin'] == '1') {
            $valid = $this->validate([
                'ed_soal' => 'required',
                'pilA' => 'required',
                'pilB' => 'required',
                'pilC' => 'required',
                'pilD' => 'required',
                'pilE' => 'required',
                'kunci_jawaban' => 'required',
                'poin' => 'required'
            ]);

            if ($valid) {
                $this->hydrate();
                // dd($this->id_ul, $this->ed_soal, $this->pilA, $this->pilB, $this->pilC, $this->pilD, $this->pilE, $this->kunci_jawaban, $this->poin);
                $cSoal = Soal::create([
                    'id_ulangan' => $this->id_ul,
                    'soal' => $this->ed_soal,
                    'pilihan_a' => $this->pilA,
                    'pilihan_b' => $this->pilB,
                    'pilihan_c' => $this->pilC,
                    'pilihan_d' => $this->pilD,
                    'pilihan_e' => $this->pilE,
                    'kunci_jawaban' => $this->kunci_jawaban,
                    'poin' => $this->poin,
                ]);
            }
        } else {
            $valid = $this->validate([
                'ed_soal' => 'required',
                'pilA' => 'required',
                'pilB' => 'required',
                'pilC' => 'required',
                'pilD' => 'required',
                'pilE' => 'required',
                'kunci_jawaban' => 'required',
            ]);

            if ($valid) {
                $this->hydrate();
                // dd($this->id_ul, $this->ed_soal, $this->pilA, $this->pilB, $this->pilC, $this->pilD, $this->pilE, $this->kunci_jawaban);
                $cSoal = Soal::create([
                    'id_ulangan' => $this->id_ul,
                    'soal' => $this->ed_soal,
                    'pilihan_a' => $this->pilA,
                    'pilihan_b' => $this->pilB,
                    'pilihan_c' => $this->pilC,
                    'pilihan_d' => $this->pilD,
                    'pilihan_e' => $this->pilE,
                    'kunci_jawaban' => $this->kunci_jawaban,
                ]);
            }
        }

        if ($cSoal) {
            session()->flash('pesan', 'Data Soal berhasil ditambah');
            return redirect(route('soalGuru', ['id_ul' => $this->id_ul]));
        } else {
            session()->flash('pesan', 'Data GAGAL ditambah');
            return redirect(route('soalGuru', ['id_ul' => $this->id_ul]));
        }
    }

    public function soalKe()
    {
        $jmlSoal = DB::select(
            'select COUNT(*) AS jml FROM (
                SELECT soals.id FROM soals
                JOIN ulangans ON soals.id_ulangan = ulangans.id
                WHERE soals.id_ulangan = ?
            ) jml',
            [$this->id_ul]
        );

        $no_soal = 1;

        if (intval($jmlSoal[0]->jml) > 0) {
            $no_soal = intval($jmlSoal[0]->jml) + 1;
        }

        return $no_soal;

        // return $jmlSoal;
    }

    // public function loadUl()
    // {

    // }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getUlangan($ulid)
    {
        $dul = Ulangan::find($ulid);
        return $dul;
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

        // foreach ($dMap as $k) {
        //     $this->countDM++;
        // }

        return $dMap;
    }

    public function render()
    {
        return view('livewire.guru.soal-ulangan', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUlangan($this->id_ul),
            'no_soal' => $this->soalKe(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

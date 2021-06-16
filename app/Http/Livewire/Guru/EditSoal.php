<?php

namespace App\Http\Livewire\Guru;

use App\Models\Soal;
use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditSoal extends Component
{
    public $ids, $noc, $soals, $id_ul, $nav_dmid;
    public $ed_soal, $pilA, $pilB, $pilC, $pilD, $pilE, $poin, $kunci_jawaban;

    public function mount($nav_dmid, $id_ul, $noc, $ids)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_ul = $id_ul;
        $this->ids = $ids;
        $this->noc = $noc;

        $this->soals = DB::select('select * from soals where id = ?', [$this->ids]);
        $this->ed_soal = $this->soals[0]->soal;
        $this->pilA = $this->soals[0]->pilihan_a;
        $this->pilB = $this->soals[0]->pilihan_b;
        $this->pilC = $this->soals[0]->pilihan_c;
        $this->pilD = $this->soals[0]->pilihan_d;
        $this->pilE = $this->soals[0]->pilihan_e;
        $this->kunci_jawaban = $this->soals[0]->kunci_jawaban;
        if ($this->soals[0]->poin != null) {
            $this->poin = $this->soals[0]->poin;
        }
    }

    public function loadById()
    {
        // $this->soals = DB::select('select * from soals where id_ulangan = ?', [$this->id_ul]);
        // $this->soals = DB::select('select * from soals where id_ulangan = ?', [$this->id_ul]);
        // $this->ed_soal = $this->soals[0]->soal;
        // $this->pilA = $this->soals[0]->pilihan_a;
        // $this->pilB = $this->soals[0]->pilihan_b;
        // $this->pilC = $this->soals[0]->pilihan_c;
        // $this->pilD = $this->soals[0]->pilihan_d;
        // $this->pilE = $this->soals[0]->pilihan_e;
        // $this->kunci_jawaban = $this->soals[0]->kunci_jawaban;
        // if ($this->soals[0]->poin != null) {
        //     $this->poin = $this->soals[0]->poin;
        // }
        // dd($this->soals[0]->soal);
        // foreach ($this->soals as $s) {
        //     $this->soal = $s->soal;
        //     $this->pilA = $s->pilihan_a;
        //     $this->pilB = $s->pilihan_b;
        //     $this->pilC = $s->pilihan_c;
        //     $this->pilD = $s->pilihan_d;
        //     $this->pilE = $s->pilihan_e;
        //     $this->kunci_jawaban = $s->kunci_jawaban;
        //     if ($s->poin != null) {
        //         $this->poin = $s->poin;
        //     }
        // }
        // return $soals;
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
                $eSoal = Soal::find($this->ids)->update([
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
                // 'pilA' => 'required',
                // 'pilB' => 'required',
                // 'pilC' => 'required',
                // 'pilD' => 'required',
                // 'pilE' => 'required',
                'kunci_jawaban' => 'required',
            ]);

            if ($valid) {
                $this->hydrate();
                // dd($this->id_ul, $this->soal, $this->pilA, $this->pilB, $this->pilC, $this->pilD, $this->pilE, $this->kunci_jawaban);
                $eSoal = Soal::find($this->ids)->update([
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

        if ($eSoal) {
            session()->flash('pesan', 'Data Soal berhasil diubah');
            return redirect(route('listSoalGuru', ['id_ul' => $this->id_ul]));
        } else {
            session()->flash('pesan', 'Data GAGAL diubah');
            return redirect(route('listSoalGuru', ['id_ul' => $this->id_ul]));
        }
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getUlangan($ulid)
    {
        $dul = Ulangan::find($ulid);
        // $this->loadById();
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
        return view('livewire.guru.edit-soal', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUlangan($this->ids),
            // 'soals' => $this->loadById(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

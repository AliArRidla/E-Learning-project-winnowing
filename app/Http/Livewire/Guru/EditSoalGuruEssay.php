<?php

namespace App\Http\Livewire\Guru;

use App\Models\SoalEssay;
use App\Models\Ulangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditSoalGuruEssay extends Component
{
    public $ids, $noc, $soals, $id_ul, $nav_dmid;
    public $ed_soal, $no_soal, $poin, $jawaban_guru, $jawaban_siswa;

    public function mount($nav_dmid, $id_ul, $noc, $ids)
    {
        $this->nav_dmid = $nav_dmid;
        $this->id_ul = $id_ul;
        $this->ids = $ids;
        $this->noc = $noc;

        $this->soals = DB::select('select * from soal_essays where id = ?', [$this->ids]);
        $this->ed_soal = $this->soals[0]->soal;
        $this->no_soal = $ids;

        $this->jawaban_guru = $this->soals[0]->jawaban_guru;
        $this->jawaban_siswa = $this->soals[0]->jawaban_siswa;
        
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

    public function saveSoal(Request $request)
    {
        // $request->validate([
        //         'id_ul' => 'required',
        //         'ed_soal' => 'required',
        //         'jawaban_guru'=> 'required',
        //         'jawaban_siswa'=> 'required',
        //         'poin'=> 'required',
        // ]);
        //         
        $eSoal = SoalEssay::find($this->ids);
                $eSoal->id_ulangan = $this->id_ul;
                $eSoal->soal = $this->ed_soal;
                $eSoal->jawaban_guru = $this->jawaban_guru;
                $eSoal->jawaban_siswa = $this->jawaban_siswa;
                $eSoal->poin  = $this->poin;
                $eSoal->save();
                
        if ($eSoal) {
            session()->flash('pesan', 'Data Soal berhasil diubah');
            return redirect(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
        } else {
            session()->flash('pesan', 'Data GAGAL diubah');
            return redirect(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
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
        return view('livewire.guru.edit-soal-ulangan-essay', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUlangan($this->ids),
            // 'soals' => $this->loadById(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

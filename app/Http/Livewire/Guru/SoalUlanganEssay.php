<?php

namespace App\Http\Livewire\Guru;

use App\Models\SoalEssay;
use App\Models\Ulangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class SoalUlanganEssay extends Component
{
    use WithFileUploads;

    // public $id_ul, $pilgan, $intPoin;
    // public $id_ul, $ed_soal, $pilA, $pilB, $pilC, $pilD, $pilE, $poin, $jawaban_guru, $no_soal, $simpan;
    public $id_ul, $ed_soal, $poin, $jawaban_guru, $no_soal, $simpan,$id_guru,$id_soal;
    public $nav_dmid, $vld=false;

    public function mount($nav_dmid, $id_ul)
    {
        // $this->rload = true;
        $this->id_ul = $id_ul;
        $this->nav_dmid = $nav_dmid; //buat apa ?

        $this->ed_soal = null; //buat apa ? soal 
        $this->pilA = null;
        $this->pilB = null;
        $this->pilB = null;

        $dGur = DB::select('select user_id as id from role_user where user_id = ?', [Auth::user()->id]);
        $this->id_guru = $dGur[0]->id;
        
        // menghitunh nomor soal
        $jmlSoal = DB::select(
            'select COUNT(*) AS jml FROM (
                SELECT soal_essays.id FROM soal_essays
                JOIN ulangans ON soal_essays.id_ulangan = ulangans.id
                WHERE soal_essays.id_ulangan = ?
            ) jml',
            [$this->id_ul]
        );

        $this->no_soal = 0;

        if (intval($jmlSoal[0]->jml) > 0) {
            $this->no_soal = intval($jmlSoal[0]->jml) + 1;
        }
    }

    public function saveSoal()
    {
        $pn = $this->getUlangan($this->id_ul);
        if ($pn['is_poin'] == '1') {
            
            if ($this->ed_soal == null || $this->jawaban_guru == null || $this->poin == null) {
                $this->vld = false;
            } else {
                $this->vld = true;
            }

            if ($this->vld == true) {
                $this->hydrate();
                
                // dd($this->id_ul, $this->ed_soal, $this->pilA, $this->pilB, $this->pilC, $this->pilD, $this->pilE, $this->jawaban_guru, $this->poin);
                $cSoal = SoalEssay::create([
                    // 'user_id_guru' => 2,                    
                    'id_soal' => $this->id_soal,                    
                    'id_ulangan' => $this->id_ul,                    
                    'soal' => $this->ed_soal,                    
                    'jawaban_guru' => $this->jawaban_guru,
                    // 'jawaban_siswa' => 'kosong',
                    'poin' => $this->poin,
                    
                ]);
            } else {
                // return reload
                session()->flash('errpesan', 'Data Soal nomor '.$this->no_soal.' GAGAL ditambahkan! Mohon isi semua kolom!');
                return redirect()->to(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
            }
        } else {
            
            if ($this->ed_soal == null || $this->jawaban_guru == null) {
                $this->vld = false;
            } else {
                $this->vld = true;
            }
            
            if ($this->vld == true) {
                $this->hydrate();
                // dd($this->id_ul, $this->ed_soal, $this->pilA, $this->pilB, $this->pilC, $this->pilD, $this->pilE, $this->jawaban_guru);
                $cSoal = SoalEssay::create([
                    'user_id_guru' => $this->id_guru,
                    'id_ulangan' => $this->id_ul,    
                    // 'id_ulangan' => 3434,                 
                    'id_soal' => $this->no_soal,                    
                    'soal' => $this->ed_soal,                    
                    'jawaban_guru' => $this->jawaban_guru,
                    // 'jawaban_siswa' => 'kosong',
                    
                ]);
                // dd($cSoal);
            } else {
                // return reload
                session()->flash('errpesan', 'Data Soal nomor '.$this->no_soal.' GAGAL ditambahkan! Mohon isi semua kolom!');
                return redirect()->to(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
            }
        }

        if ($cSoal) {
            // $this->simpan = true;
            // $this->emit('sumDestroy');
            // if ($this->simpan == false) {
            session()->flash('pesan', 'Data Soal berhasil ditambah');
            return redirect()->to(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
            // }
        } else {
            session()->flash('errpesan', 'Data GAGAL ditambah');
            return redirect()->to(route('listSoalGuru', ['nav_dmid' => $this->nav_dmid, 'id_ul' => $this->id_ul]));
        }
    }

    // public function soalKe()
    // {
    //     $jmlSoal = DB::select(
    //         'select COUNT(*) AS jml FROM (
    //             SELECT soals.id FROM soals
    //             JOIN ulangans ON soals.id_ulangan = ulangans.id
    //             WHERE soals.id_ulangan = ?
    //         ) jml',
    //         [$this->id_ul]
    //     );

    //     $no_soal = 1;

    //     if (intval($jmlSoal[0]->jml) > 0) {
    //         $no_soal = intval($jmlSoal[0]->jml) + 1;
    //     }

    //     return $no_soal;

    //     // return $jmlSoal;
    // }

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
        return view('livewire.guru.soal-ulangan-essay', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataUl' => $this->getUlangan($this->id_ul),
            // 'no_soal' => $this->soalKe(),
        ])->layout('layouts.layt', [
            'getDMapGuru' => $this->getDMap(),
        ]);
    }
}

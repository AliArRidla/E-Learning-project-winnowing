<?php

namespace App\Http\Livewire\Admin;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $count=0, $guru, $bcg, $cmg;
    
    public function countGuru()
    {
        $jmlGuru = DB::table('gurus')->count();
        // dd($jmlGuru);
        return $jmlGuru;
    }

    public function countSiswa()
    {
        $jmlSiswa = DB::table('siswas')->count();
        // dd($jmlGuru);
        return $jmlSiswa;
    }

    public function countKelas()
    {
        $jmlKelas = DB::table('kelas')->count();
        // dd($jmlGuru);
        return $jmlKelas;
    }

    public function countMapel()
    {
        $jmlMapel = DB::table('detail_mapels')->count();
        // dd($jmlGuru);
        return $jmlMapel;
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
    
    public function getGuru()
    {
        if(Auth::user()->hasRole('admin')) {
            return DB::select('select u.name, u.updated_at
                from users as u
                join gurus as g on g.user_id = u.id
                order by updated_at DESC limit 5');
        } else {
            return redirect(route('login'));
        }
    }

    public function getSiswa()
    {
        if(Auth::user()->hasRole('admin')) {
            return DB::select('select u.name, u.updated_at
                from users as u
                join siswas as s on s.user_id = u.id
                order by updated_at DESC limit 5');
        } else {
            return redirect(route('login'));
        }
    }

    public function chartMonthsG()
    {
        $guruss     = Guru::select(DB::raw("Year(created_at) as year"))
                        ->whereYear('created_at','<=',date('Y'))
                        ->groupBy(DB::raw("Year(created_at)"))
                        ->pluck('year');
        $this->guru = $guruss;
        return $guruss;
    }

    public function barChartGuru()
    {
        $jmlBarGuru = Guru::select(DB::raw("COUNT(*) as count"))
                        ->whereYear('created_at','<=',date('Y'))
                        ->groupBy(DB::raw("Year(created_at)"))
                        ->pluck('count');
        $arrBCG = [];
        foreach($jmlBarGuru as $k => $v){
            array_push($arrBCG, intval($v));
        }
        return $arrBCG;
        // return $jmlBarGuru;
    }
    
    public function ddm(){
        $bcg = $this->barChartGuru();
        $arrBCG = [];
        foreach($bcg as $k => $v){
            array_push($arrBCG, $v);
        }
        dd(json_encode($arrBCG), 'bisa');
    }

    public function chartMonthsS()
    {
        $siswa     = Siswa::select(DB::raw("Year(created_at) as year"))
                        ->whereYear('created_at','<=',date('Y'))
                        ->groupBy(DB::raw("Year(created_at)"))
                        ->pluck('year');
        return $siswa;
    }

    public function barChartSiswa()
    {
        $jmlBarSiswa = Siswa::select(DB::raw("COUNT(*) as count"))
                        ->whereYear('created_at','<=',date('Y'))
                        ->groupBy(DB::raw("Year(created_at)"))
                        ->pluck('count');
        $arrBCS = [];
        foreach($jmlBarSiswa as $k => $v){
            array_push($arrBCS, intval($v));
        }
        return $arrBCS;
        // return $jmlBarSiswa;
    }
    
    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('admin')) {
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
        return view('livewire.admin.dashboard', [
            'jmlGuru' => $this->countGuru(),
            'jmlSiswa' => $this->countSiswa(),
            'jmlKelas' => $this->countKelas(),
            'jmlMapel' => $this->countMapel(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
            'dataGuru' => $this->getGuru(),
            'dataSiswa' => $this->getSiswa(),
            'barChartGuru' => $this->barChartGuru(),
            'chartMonthsG' => $this->chartMonthsG(),
            'barChartSiswa' => $this->barChartSiswa(),
            'chartMonthsS' => $this->chartMonthsS(),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}
<?php

namespace App\Http\Livewire\Admin;

use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
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

    public function getAcc($id)
    {
        $data = '';
        // if (Auth::user()->hasRole('guru')) {
        //     $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
        //     from gurus as g
        //     join users as u on u.id = g.user_id
        //     where u.id = ?', [$id]);
        // } else 
        if (Auth::user()->hasRole('admin')) {
            $data = DB::select('select a.id as rid, a.user_id as uid, a.foto
            from admins as a
            join users as u on u.id = a.user_id
            where u.id = ?', [$id]);
        } else {
            return redirect(route('login'));
        }
        // else if (Auth::user()->hasRole('siswa')) {
        //     // $data = DB::select('select a.id, a.user_id as uid, a.foto
        //     // from siswas as a
        //     // join users as u on u.id = a.user_id
        //     // where a.id = ?', [$id]);
        // }
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
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
        ]);
    }
}

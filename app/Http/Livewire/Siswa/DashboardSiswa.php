<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardSiswa extends Component
{
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
        // else if (Auth::user()->hasRole('admin')) {
        //     $data = DB::select('select a.id as rid, a.user_id as uid, a.foto
        //     from admins as a
        //     join users as u on u.id = a.user_id
        //     where u.id = ?', [$id]);
        // } 

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
        return view('livewire.siswa.dashboard-siswa', [
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt');
    }
}

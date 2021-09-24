<?php

namespace App\Http\Livewire\Admin;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DataGuru extends Component
{
    public $name, $email, $password;
    public $idDel, $names;

    protected $messages = [
        'name.required' => 'Mohon isi kolom Nama',
        'email.required' => 'Mohon isi kolom Email',
        'email.email' => 'Format Email tidak valid.',
        'email.unique' => 'Email sudah terpakai. Mohon gunakan yang lain.',
        'password.required' => 'Mohon isi kolom Password',
        'password.min' => 'Mohon isi kolom Password minimal 8 karakter.',
    ];

    public function addGuru()
    {
        // return redirect(route('dashboardAdm'));
        if (Auth::user()->hasRole('admin')) {
            // dd($request->all());
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            // User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            // ]);

            $userG = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $userG->attachRole('guru');

            $guru = Guru::create([
                'user_id' => $userG->id,
                // 'name' => $request->input('name'),
            ]);

            if ($guru) {
                session()->flash('pesan-s', 'Data berhasil ditambah');
                return redirect(route('dataGuru'));
            } else {
                session()->flash('pesan-e', 'Data GAGAL ditambah');
                return redirect(route('dataGuru'));
            }
            // Guru::create([
            //     'user_id' => $userG->id,
            //     'name' => $request->input('name'),
            // ]);

            // return redirect(route('tambahGuru'));
        } else {
            return redirect(route('login'));
        }
    }

    public function allNull()
    {
        $this->names = null;
    }

    public function getAll()
    {
        if (Auth::user()->hasRole('admin')) {
            $users = DB::select('select g.id, g.user_id, g.nip, u.name, g.jabatan, u.email
            from gurus as g
            join users as u on u.id = g.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where r.name = ?', ['guru']);
            // $users = DB::select('select * from users');
            // DB::select('select * from users where active = ?', [1])
            return $users;
        } else {
            return redirect(route('login'));
        }
    }

    public function getByID($id)
    {
        if (Auth::user()->hasRole('admin')) {
            $guru = DB::select('select g.id, g.user_id, g.foto, g.nip, u.name, g.jabatan, u.email, g.no_hp, 
            r.display_name as peran, g.jenis_kelamin, g.alamat
            from gurus as g
            join users as u on u.id = g.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where g.id = ?', [$id]);
            // $users = DB::select('select * from users');
            // DB::select('select * from users where active = ?', [1])
            return $guru;
        } else {
            return redirect(route('login'));
        }
    }

    public function deleteUser($id)
    {
        // $delGuru = Guru::find($id);
        $delUser = User::find($id);
        // $delGuru->delete();
        $delUser->delete();
        session()->flash('pesan-s', 'Data berhasil dihapus');
        return redirect(route('dataGuru'));
        // dd($delGuru);
    }

    public function saveIdDel($id, $name)
    {
        $this->idDel = $id;
        $this->names = $name;
        // dd($this->idDel, $this->names);
    }

    public function reload()
    {
        return redirect(route('dataGuru'));
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

    public function countKelas()
    {
        $jmlKelas = DB::table('kelas')->count();
        // dd($jmlGuru);
        return $jmlKelas;
    }

    public function getAcc($id)
    {
        $data = '';
        if (Auth::user()->hasRole('guru')) {
            $data = DB::select('select g.id as rid, g.user_id as uid, g.foto
            from gurus as g
            join users as u on u.id = g.user_id
            where u.id = ?', [$id]);
        } else if (Auth::user()->hasRole('admin')) {
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
        // $this->reload();
        return view('livewire.admin.data-guru', [
            'dataGuru' => $this->getAll(),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

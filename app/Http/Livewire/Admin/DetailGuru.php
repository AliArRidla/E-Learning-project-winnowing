<?php

namespace App\Http\Livewire\Admin;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailGuru extends Component
{
    use WithFileUploads;

    public $guru;
    public $idu, $idg, $nip, $name, $jabatan, $email, $no_hp, $peran, $jenis_kelamin, $alamat, $old_email;
    // public $foto, $tfoto;
    protected $messages = [
        'name.required' => 'Mohon isi kolom Nama',
        'email.required' => 'Mohon isi kolom Email',
        'email.email' => 'Format Email tidak valid.',
        'email.unique' => 'Email sudah terpakai. Mohon gunakan yang lain.',
    ];

    public function mount($id)
    {
        $this->idg = $id;
    }

    // public function rules()
    // {
    //     return [
    //         'foto' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
    //         'nip' => ['numeric', 'min:5'],
    //         'name' => 'required|min:3|max:50',
    //         'jabatan' => ['min:3'],
    //         'email' => ['required', 'email', 'min:5'],
    //         'no_hp' => ['required', 'min:5', 'numeric'],
    //         'alamat' => ['min:5'],
    //     ];
    // }

    public function getByID($id)
    {
        if (Auth::user()->hasRole('admin')) {
            $guru = DB::select('select g.id, g.user_id as uid, g.foto, g.nip, u.name, g.jabatan, u.email, g.no_hp, 
            r.display_name as peran, g.jenis_kelamin, g.alamat
            from gurus as g
            join users as u on u.id = g.user_id
            join role_user as ru on ru.user_id = u.id 
            join roles AS r on r.id = ru.role_id
            where g.id = ?', [$id]);
            return $guru;
        } else {
            return redirect(route('login'));
        }
    }

    public function loadDetail($id)
    {
        if (Auth::user()->hasRole('admin')) {
            $this->idg = $id;
            $dg = DB::select('select g.id, g.user_id as uid, u.name, u.email
                from gurus as g
                join users as u on u.id = g.user_id
                where g.id = ?', [$this->idg]);
            // dd($g);
            // $this->idg = $g->id;
            foreach ($dg as $g) {
                $this->idu = $g->uid;
                $this->email = $g->email;
                $this->old_email = $g->email;
                $this->name = $g->name;
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function updateGuru()
    {
        if (Auth::user()->hasRole('admin')) {
            // dd($this->modelData());
            // $f = Guru::find($this->idg);
            // $f->nip = $this->nip;
            // $f->jenis_kelamin = $this->jenis_kelamin;
            // $f->no_hp = $this->no_hp;
            // $f->alamat = $this->alamat;
            // $f->jabatan = $this->jabatan;
            // $f->save();
            // dd($f->id);

            // $valData = '';

            // if ($f->foto == null) {
            // $valData = $this->validate([
            //     'name' => 'required|min:3|max:100',
            //     'email' => ['required', 'email', 'min:5'],
            // ]);

            if ($this->old_email == $this->email) {
                $valDataa = $this->validate([
                    // 'tfoto' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => 'required|min:3',
                    'email' => 'required|email',
                    // 'jenis_kelamin' => 'required',
                    // 'no_hp' => 'required|min:5|numeric',
                    // 'alamat' => 'required|min:5',
                    // 'jabatan' => 'required|min:3',
                ]);
            } else {
                $valDataa = $this->validate([
                    // 'tfoto' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => 'required|min:3',
                    'email' => 'required|email|unique:users',
                    // 'jenis_kelamin' => 'required',
                    // 'no_hp' => 'required|min:5|numeric',
                    // 'alamat' => 'required|min:5',
                    // 'jabatan' => 'required|min:3',
                ]);
            }


            // dd($valDataa);

            // $valDataa = [
            //     'nip' => $this->nip,
            //     'jenis_kelamin' => $this->jenis_kelamin,
            //     'no_hp' => $this->no_hp,
            //     'alamat' => $this->alamat,
            //     'jabatan' => $this->jabatan,
            // ];
            // $valDataa['foto'] = $this->tfoto->store('profil_guru', 'public');

            // User::find($this->idu)->update($valData);
            // Guru::find($this->idg)->update($this->modelData());
            // Guru::where('id', $this->idg)
            //     ->where('user_id', $this->idu)
            //     ->update($valDataa);
            // session()->flash('pesan', 'Data berhasil diubah');

            // // ImgCarIdenSekolah::find($this->id_img)->update($valData);
            // return redirect(route('profilGID', ['id' => $this->idg]));
            // } else {
            // }

            if ($valDataa) {
                User::find($this->idu)->update($this->modelData());
                session()->flash('pesan-s', 'Data berhasil diubah');
                return redirect(route('profilGID', ['id' => $this->idg]));
            } else {
                session()->flash('pesan-e', 'Data GAGAL diubah');
                return redirect(route('profilGID', ['id' => $this->idg]));
            }


            // if ($this->tfoto != null) {
            //     dd("not null");
            //     $valData = $this->validate([
            //         'tempImg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //         'keterangan' => 'required|min:3|max:50',
            //         'kategori' => 'required|min:3|max:50',
            //     ]);

            //     $valData['imgIden'] = $this->tempImg->store('img_car_iden_sekolahs', 'public');
            //     unlink('storage/' . $this->imgIdent);
            // } else {
            //     dd("null");
            //     $valData = $this->validate([
            //         'keterangan' => 'required|min:3|max:50',
            //     ]);
            // }
        } else {
            return redirect(route('login'));
        }
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            // 'nip' => $this->nip,
            // 'jenis_kelamin' => $this->jenis_kelamin,
            // 'no_hp' => $this->no_hp,
            // 'alamat' => $this->alamat,
            // 'jabatan' => $this->jabatan,
        ];
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
        return view('livewire.admin.detail-guru', [
            'detailGuru' => $this->getByID($this->idg),
            'dataAcc' => $this->getAcc(Auth::user()->id),
        ])->layout('layouts.layt', [
            'cekJurusan' => $this->cekJurusan(),
            'jmlKelas' => $this->countKelas(),
            'cekDaftarMapel' => $this->cekDaftarMapel(),
        ]);
    }
}

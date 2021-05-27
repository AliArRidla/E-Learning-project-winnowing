<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfilAcc extends Controller
{
    public function crop(Request $request)
    {
        $path = 'storage/profilPic/';
        $file = $request->file('foto');
        $new_image_name = 'ProfilPic' . date('Ymd') . uniqid() . '.jpg';
        // dd($new_image_name);
        if (Auth::user()->hasRole('admin')) {
            $data = Admin::where('user_id', Auth::user()->id)->get();
        } else if (Auth::user()->hasRole('guru')) {
            $data = Guru::where('user_id', Auth::user()->id)->get();
        } else if (Auth::user()->hasRole('siswa')) {
            $data = Siswa::where('user_id', Auth::user()->id)->get();
        }

        foreach ($data as $key) {
            if ($key->foto != null) {
                unlink($path . $key->foto);
            }
        }

        $upload = $file->move(public_path($path), $new_image_name);

        if ($upload) {
            if (Auth::user()->hasRole('admin')) {
                Admin::where('user_id', Auth::user()->id)->update(['foto' => $new_image_name]);
            } else if (Auth::user()->hasRole('guru')) {
                Guru::where('user_id', Auth::user()->id)->update(['foto' => $new_image_name]);
            } else if (Auth::user()->hasRole('siswa')) {
                Siswa::where('user_id', Auth::user()->id)->update(['foto' => $new_image_name]);
            }
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    // public function index()
    // {
    //     if (Auth::user()->hasRole('admin')) {
    //         $data = DB::select('select u.id as uid, u.name, u.email,
    //         a.foto, a.nip, a.jenis_kelamin, a.no_hp, a.alamat, a.jabatan
    //         from users as u
    //         join admins as a on a.user_id = u.id
    //         where u.id = ?', [Auth::user()->id]);
    //     } else if (Auth::user()->hasRole('guru')) {
    //         $data = DB::select('select u.id as uid, u.name, u.email,
    //         g.foto, g.nip, g.jenis_kelgmin, g.no_hp, g.alamat, g.jabatan
    //         from users as u
    //         join gurus as g on g.user_id = u.id
    //         where u.id = ?', [Auth::user()->id]);
    //     }

    //     return view('profile-acc')->with($data);
    // }

    // public function crop()
    // {
    //     dd("crop");
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Path\To\DOMDocument;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class MateriController extends Controller
{
    // public $nama_materi, $file_materi, $content;
    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }

    public function index()
    {
        if (Auth::user()->hasRole('guru')) {
            $mat = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid,
            g.id as rid, g.user_id as uid, g.foto, mat.nama_materi, mat.content, mat.id as matid
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            join materis as mat on mat.id_detMapel = dm.id
            where g.user_id = ?', [Auth::user()->id]);
            // var_dump($mat);
            return view('guru/materi', compact('mat'));
        } else {
            return redirect(route('login'));
        }

    }

    // public function getAll($id)
    // {
    //     if (Auth::user()->hasRole('guru')) {
    //         $materi = DB::select('select m.nama_mapel, k.nama_kelas, dm.id as dmid
    //         from detail_mapels as dm 
    //         join kelas as k on k.id = dm.id_kelas
    //         join mapels as m on m.id = dm.id_mapel
    //         where dm.id = ?', [$id]);
    //         return $materi;
    //     } else {
    //         return redirect(route('login'));
    //     }
    // }

    public function create()
    {
        if (Auth::user()->hasRole('guru')) {
            $materi = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid, 
            g.id as rid, g.user_id as uid, g.foto
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            where g.user_id = ?', [Auth::user()->id]);
            return view('guru/materi_tambah', compact('materi'));
            // return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    // public function hydrate()
    // {
    //     $this->resetErrorBag();
    //     $this->resetValidation();
    // }
    
    public function store($nav_dmid, Request $request)
    {
        if (Auth::user()->hasRole('guru')) {
            $this->validate($request,[
                // 'tujuanMat' => 'required',
                // // // 'id_detMapel' => 'required',
                'nama_materi' => 'required',
                'content' => 'required',
                'file_materi' => 'required'
            ]);
            // $this->hydrate();
            // dd($nav_dmid, $request->nama_materi, $request->file_materi, $request->content);
            $storage = "storage/content";
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
            libxml_clear_errors();
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $img) {
                $src = $img->getAttribute('src');
                if(preg_match('/data:image/', $src)){
                    preg_match('/data:image\/(?<mime>.*?)\;/',$src,$groups);
                    $mimetype = $groups['mime'];
                    $fileNameContent = uniqid();
                    $fileNameContentRand = substr(md5($fileNameContent),6,6).'_'.time();
                    $filepath= ("$storage/$fileNameContentRand.$mimetype");
                    $image = Image::make($src)
                        ->resize(1200,1200)
                        ->encode($mimetype,100)
                        ->save(public_path($filepath));
                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                    $img->setAttribute('class', 'img-responsive');
                }
            }
                // 'id_detMapel', 'nama_materi', 'file_materi','content',
            $ut = $request->file('file_materi');  
            $namafile = time() . "_" . $ut->getClientOriginalName(); 
            $ut->move(public_path('storage/content'), $namafile);
                    
            $materi = Materi::create([
                'id_detMapel' => $nav_dmid,
                'nama_materi' => $request->nama_materi,
                'file_materi' => $namafile,
                'content' => $dom->saveHTML()
            ]);
                
            if ($materi) {
                return redirect(route('dataMateri', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data Berhasil ditambah');
            } else {
                return redirect(route('dataMateri', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        }
        else {
            return redirect(route('login'));
        }
    }

    public function show($id)
    {
        if (Auth::user()->hasRole('guru')) {
            $mat = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid,
            g.id as rid, g.user_id as uid, g.foto, mat.nama_materi, mat.content, mat.id as matid, mat.id_detMapel as mapel
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            join materis as mat on mat.id_detMapel = dm.id
            where g.user_id = ?', [Auth::user()->id]);
            $materi = Materi::find($id);
            return view('guru/materi_detail', compact('mat','materi'));
        } else {
            return redirect(route('login'));
        }
    }

    public function edit($nav_dmid, $id)
    {
        if (Auth::user()->hasRole('guru')) {
            $editMat = DB::select('select u.name, m.nama_mapel, k.nama_kelas, dm.id as dmid, 
            mat.nama_materi, mat.id as matid, mat.file_materi, mat.content
            from detail_mapels as dm 
            join kelas as k on k.id = dm.id_kelas
            join mapels as m on m.id = dm.id_mapel
            join gurus as g on g.id = dm.id_guru
            join users as u on u.id = g.user_id
            join materis as mat on mat.id_detMapel = dm.id
            where g.user_id = ?',  [Auth::user()->id]);
            $materi = Materi::find($id);
            // dataMateriEdit
            return view(route('dataMateriEdit', ['nav_dmid' => $nav_dmid]), compact('editMat','materi'));
            // return $materi;
        } else {
            return redirect(route('login'));
        }
    }

    public function update($nav_dmid, $idMat, Request $request)
    {
        if (Auth::user()->hasRole('guru')) {
            $materi = Materi::find($idMat);
            // $mt='';
            // if($materi != null){
            //      dd($materi->file_materi);
            //     // // foreach ($materi as $mat) {
            //     //     $mt = $mat['file_materi'];
            //     // }
            // }
           
            $gambar_name = '';
            $gambar = $request->file('file_materi');

            if ($gambar != '') {
                $request->validate([
                    'nama_materi' => 'required',
                    'file_materi' => 'required',
                    'content' => 'required'
                ]);
                // // if($mar){
                    // dd($materi->id);
                // }
                if ($gambar == true) {
                    unlink('storage/content/' . $materi->file_materi);
                }
                $gambar_name = time() . "_" . $gambar->getClientOriginalName();
                $gambar->move(public_path('storage/content/'), $gambar_name);
            }
            else {
                $this->validate($request,[
                    // 'id_detMapel' => 'required',
                    'nama_materi' => 'required',
                    // 'desc_materi' => 'required',
                    'content' => 'required'
                ]);
            } 

            $storage = "storage/content";
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
            libxml_clear_errors();
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $img) {
                $src = $img->getAttribute('src');
                if(preg_match('/data:image/', $src)){
                    preg_match('/data:image\/(?<mime>.*?)\;/',$src,$groups);
                    $mimetype = $groups['mime'];
                    $fileNameContent = uniqid();
                    $fileNameContentRand = substr(md5($fileNameContent),6,6).'_'.time();
                    $filepath= ("$storage/$fileNameContentRand.$mimetype");
                    $image = Image::make($src)
                        ->resize(1200,1200)
                        ->encode($mimetype,100)
                        ->save(public_path($filepath));
                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                    $img->setAttribute('class', 'img-responsive');
                }
            }
            $materi = Materi::where('id', $materi->id)
            ->update([
                'id_detMapel' => $nav_dmid,
                'nama_materi' => $request->nama_materi,
                'content' => $dom->saveHTML(),
                'file_materi' => $gambar_name
            ]);
                
            if ($materi) {
                return redirect(route('dataMateri', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data Berhasil ditambah');
            } else {
                return redirect(route('dataMateri', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        } 
        else {
            return redirect(route('login'));
        }
    }


    public function destroy()
    {
       
    }
    
    public function download($id)
    {
        $materi = Materi::findOrFail($id);
        $fm = $materi->file_materi;
        return response()->download(public_path('storage/content/' . $fm));
    }
}

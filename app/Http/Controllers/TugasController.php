<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Path\To\DOMDocument;
use Intervention\Image\ImageManagerStatic as Image;

class TugasController extends Controller
{
    public function mount($nav_dmid)
    {
        $this->nav_dmid = $nav_dmid;
    }
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store($nav_dmid, Request $request)
    {
        if (Auth::user()->hasRole('guru')) {
            $this->validate($request,[
                'nama_tugas' => 'required',
                'content' => 'required',
                'file_tugas' => 'required',
                'tanggal' => 'required'
            ]);
            // $this->hydrate();
            // dd($nav_dmid, $request->nama_tugas, $request->content, $request->file_tugas, $request->tanggal);
            $storage = "storage/file_tugas";
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
            // 'id_materi', 'nama_tugas', 'content', 'file_tugas', 'tanggal',
            $ut = $request->file('file_tugas');  
            $namafile = time() . "_" . $ut->getClientOriginalName(); 
            $ut->move(public_path('storage/file_tugas'), $namafile);
                    
            $tugas = Tugas::create([
                'id_materi' => $request->id_materi,
                'nama_tugas' => $request->nama_tugas,
                'content' => $dom->saveHTML(),
                'file_tugas' => $namafile,
                'tanggal' => $request->tanggal,
            ]);
                
            if ($tugas) {
                return redirect(route('dataTugas', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data Berhasil ditambah');
            } else {
                return redirect(route('dataTugas', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        }
        else {
            return redirect(route('login'));
        }
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update($nav_dmid, $idTgs, Request $request)
    {
        if (Auth::user()->hasRole('guru')) {
            $tugas = Tugas::find($idTgs);
           
            $gambar_name = '';
            $gambar = $request->file('file_tugas');
            // 'id_materi', 'nama_tugas', 'content', 'file_tugas', 'tanggal',
            if ($gambar != '') {
                $request->validate([
                    'nama_tugas' => 'required',
                    'content' => 'required',
                    'file_tugas' => 'required',
                    'tanggal' => 'required'
                ]);
                if ($gambar == true) {
                    unlink('storage/file_tugas/' . $tugas->file_tugas);
                }
                $gambar_name = time() . "_" . $gambar->getClientOriginalName();
                $gambar->move(public_path('storage/file_tugas/'), $gambar_name);
            }
            else {
                $this->validate($request,[
                    'nama_tugas' => 'required',
                    'content' => 'required',
                    'tanggal' => 'required'
                ]);
            } 

            $storage = "storage/file_tugas";
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
            $tugas = Tugas::where('id', $tugas->id)
            ->update([
                'id_materi' => $request->id_materi,
                'nama_tugas' => $request->nama_tugas,
                'content' => $dom->saveHTML(),
                'file_tugas' => $gambar_name,
                'tanggal' => $request->tanggal
            ]);
                
            if ($tugas) {
                return redirect(route('dataTugas', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data Berhasil ditambah');
            } else {
                return redirect(route('dataTugas', ['nav_dmid' => $nav_dmid]));
                session()->flash('msg', 'Data GAGAL ditambah');
            }
        } 
        else {
            return redirect(route('login'));
        }
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_det_mapel', 'judul_ulangan', 'tgl_ulangan', 'waktu_mulai', 'waktu_selesai', 'is_poin'
    ];
}

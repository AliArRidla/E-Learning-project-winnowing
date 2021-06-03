<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPresensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_presensi', 'id_siswa', 'keterangan', 'waktu_absen',
    ];
}

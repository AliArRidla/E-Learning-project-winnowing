<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_det_mapel', 'hari_absen', 'waktu_mulai', 'waktu_selesai', 'jangka_waktu',
    ];
}

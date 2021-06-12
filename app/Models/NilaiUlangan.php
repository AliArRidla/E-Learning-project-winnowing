<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiUlangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_siswa', 'id_ulangan', 'nilai', 'benar', 'salah',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalEssay extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id_guru','user_id_siswa','id_ulangan', 'soal', 'jawaban_guru', 'jawaban_siswa', 'poin',        
    // 'id_ulangan',
    ];

    public function ulangan()
    {
        return $this->belongsTo(Ulangan::class, 'id_ulangan');
    }

    public function user_siswa()
    {
        return $this->hasone(User::class, 'user_id_siswa');
    }

    public function user_guru()
    {
        return $this->hasone(User::class, 'user_id_guru');
    }
}

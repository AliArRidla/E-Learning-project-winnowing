<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanEssay extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_soal','user_id','id_ulangan', 'jawaban_siswa', 'poin',        
    ];

    public function ulangan()
    {
        return $this->belongsTo(Ulangan::class, 'id_ulangan');
    }

    public function user_siswa()
    {
        return $this->hasone(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalEssay extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id_siswa','id_ulangan', 'soal', 'jawaban_guru', 'jawaban_siswa', 'poin',        
    // 'id_ulangan',
    ];

    public function ulangan()
    {
        return $this->belongsTo(Ulangan::class, 'id_ulangan');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'user_id_siswa');
    }
}

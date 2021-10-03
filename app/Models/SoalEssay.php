<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalEssay extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_ulangan', 'soal', 'jawaban_guru', 'jawaban_siswa', 'poin',        
    // 'id_ulangan',
    ];

    public function ulangan()
    {
        return $this->belongsTo(Ulangan::class, 'id_ulangan');
    }
}

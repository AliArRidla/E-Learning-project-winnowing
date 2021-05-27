<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    // public $guarded = [];
    protected $fillable = [
        'user_id', 'foto', 'nip', 'jenis_kelamin', 'no_hp', 'alamat', 'jabatan',
    ];
}

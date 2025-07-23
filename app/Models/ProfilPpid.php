<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPpid extends Model
{
    use HasFactory;

    protected $table = 'profil_ppid';
    protected $primaryKey = 'id_profil';
    public $timestamps = true;

    protected $fillable = [
        'deskripsi',
        'kategori'
    ];
}

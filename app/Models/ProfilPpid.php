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
        'deskripsi_profil',
        'visi_ppid',
        'misi_ppid',
        'tugas_ppid',
        'fungsi_ppid',
    ];
}

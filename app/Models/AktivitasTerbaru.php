<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasTerbaru extends Model
{
    protected $table = 'aktivitas_terbaru';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = true;
    protected $fillable = ['username', 'jenis_aktivitas', 'deskripsi_aktivitas', 'waktu_aktivitas'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskripsiHalamanDokumen extends Model
{
    use HasFactory;
    protected $table = 'deskripsi_halaman_dokumen';
    protected $primaryKey = 'id_deskripsi';
    public $timestamps = true;

    protected $fillable = [
        'id_deskripsi',
        'deskripsi',
        'kategori_dokumen'
    ];
}

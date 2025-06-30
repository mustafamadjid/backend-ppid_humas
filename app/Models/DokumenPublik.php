<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class DokumenPublik extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = "dokumen_publik";
    protected $primaryKey = "id_dokumen";
    protected $fillable = 
    [
        'id_dokumen',
        'nama_dokumen',
        'path_dokumen',
        'kategori_dokumen',
        'tahun_dokumen'
    ];
}

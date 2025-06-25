<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPublik extends Model
{
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    protected $primaryKey = 'id_kategori';
    protected $table = 'kategori_dokumen';

    protected $fillable = [
        'jenis_dokumen',
        'kategori',
    ];

    public $timestamps = true;
}

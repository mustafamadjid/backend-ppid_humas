<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunDokumenTampil extends Model
{
    protected $table = 'tahun_dokumen_tampil';
    public $timestamps = true;
    protected $primaryKey = 'id_tahun_dokumen';
    protected $fillable = ['tahun_dokumen'];
}

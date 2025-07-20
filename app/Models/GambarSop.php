<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarSop extends Model
{
    use HasFactory;
    protected $table = 'gambar_sop_beranda';
    protected $primaryKey = 'id_gambar';
    protected $fillable = ['path_gambar','judul_sop'];
    public $timestamps = true;


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarSop extends Model
{
    use HasFactory;
    protected $table = 'gambar_sop_beranda';
    protected $primaryKey = 'id_gambar';
    protected $fillable = ['path_gambar', 'order', 'is_active'];
    public $timestamps = true;

    protected $casts = ['is_active' => 'boolean'];
}

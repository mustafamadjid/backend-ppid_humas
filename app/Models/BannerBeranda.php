<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerBeranda extends Model
{
    use HasFactory;
    protected $table = 'banner_beranda';
    protected $primaryKey = 'id_gambar';
    public $timestamps = true;
    protected $fillable = [
        'path_gambar',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}

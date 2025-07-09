<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SematanAplikasi extends Model
{
    use HasFactory;
    protected $table = 'sematan_aplikasi';
    protected $primaryKey = 'id_sematan';
    public $timestamps = true;
    protected $fillable=[
        'judul_sematan',
        'url_sematan',
        'icon'
    ];
}

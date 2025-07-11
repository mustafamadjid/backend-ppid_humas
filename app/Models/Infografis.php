<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    protected $table = 'infografis';
    protected $primaryKey = 'id_infografis';
    public $timestamps = true;
    protected $fillable = ['judul_infografis', 'path_infografis'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanAssginments extends Model
{
    protected $table = 'jabatan_assignments';
    protected $primaryKey = 'id_assignment';
    public $timestamps = true;
    protected $fillable = [
        'id_pegawai',
        'id_jabatan'
    ];
}

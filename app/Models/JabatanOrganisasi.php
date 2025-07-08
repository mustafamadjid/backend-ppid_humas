<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanOrganisasi extends Model
{
    use HasFactory;
    protected $table = 'jabatan_organisasi';
    protected $primaryKey = 'id_jabatan';
    protected $fillable = [
        'jabatan'
    ];
    public $timestamps = true;

}

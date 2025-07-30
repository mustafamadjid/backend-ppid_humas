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
        'jabatan',
        'id_atasan'
    ];
    public $timestamps = true;

    public function bawahan()
    {
        return $this->hasMany(JabatanOrganisasi::class, 'id_atasan', 'id_jabatan');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan', 'id_jabatan');
    }

}

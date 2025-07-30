<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = true;
    protected $fillable = ['id_pegawai', 'nama_pegawai', 'email', 'path_foto_pegawai','id_jabatan','nip','status'];

     // Tambahkan method relasi di bawah ini
    public function jabatanOrganisasi()
    {
        return $this->belongsTo(JabatanOrganisasi::class, 'id_jabatan', 'id_jabatan');
        
    }


    

}

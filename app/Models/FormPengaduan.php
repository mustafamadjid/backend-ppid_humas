<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPengaduan extends Model
{
    protected $table = 'data_form_pengaduan';
    protected $primaryKey = 'id_pelapor';
    public $timestamps = true;
    protected $fillable = [
      'nama_pelapor', 
      'no_ktp_pelapor', 
      'alamat_pelapor', 
      'no_telp_pelapor', 
      'email_pelapor', 
      'nama_terlapor', 
      'jabatan_terlapor', 
      'deskripsi_penyalahgunaan', 
      'path_file_bukti',
      'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormKeberatan extends Model
{
    protected $primaryKey = 'id_pemohon';    
    protected $table = 'data_form_pengajuan_keberatan';
    public $timestamps = true;

    protected $fillable = [
        'id_pemohon',
        'nama_pemohon',
        'no_ktp_pemohon',
        'alamat_pemohon',
        'no_telp_pemohon',
        'email_pemohon',
        'pekerjaan_pemohon',
        'tujuan_pengajuan',
        'alasan_pengajuan',
        'path_file_bukti',
    ];
}

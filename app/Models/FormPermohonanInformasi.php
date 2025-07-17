<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPermohonanInformasi extends Model
{
    protected $table = 'data_form_permohonan_informasi';
    protected $primaryKey = 'id_permohonan';
    protected $fillable = [
        'nama_pemohon',
        'no_ktp_pemohon',
        'alamat_pemohon',
        'no_telp_pemohon',
        'email_pemohon',
        'kebutuhan_informasi_pemohon',
        'alasan_permintaan',
        'nama_pengguna',
        'no_ktp_pengguna',
        'alamat_pengguna',
        'no_telp_pengguna',
        'email_pengguna',
        'kebutuhan_informasi_pengguna',
        'alasan_penggunaan',
        'cara_perolehan_informasi',
        'format_informasi',
        'cara_pengiriman_informasi',
        'status'
    ];

    public $timestamps = true;
}

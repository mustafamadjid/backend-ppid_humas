<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormContactUs extends Model
{
    protected $table = 'form_contact_us';
    protected $primaryKey = 'id_form';
    public $timestamps = true;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telp',
        'subjek',
        'pesan',
        'status'
    ];
}

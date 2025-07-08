<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaklumatPelayanan extends Model
{
    use HasFactory;
    protected $table = 'maklumat_pelayanan';
    protected $primaryKey = 'id_maklumat';
    public $timestamps = true;
    protected $fillable = [
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

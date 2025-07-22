<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitor';
    protected $primaryKey = 'id_visitor';
    public $timestamps = true;

    protected $fillable = [
        'ip_address',
        'count',
    ];
}

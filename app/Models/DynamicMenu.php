<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicMenu extends Model
{
    protected $table = 'menu_dinamis_beranda';
    protected $primaryKey = 'id_menu';

    public $timestamps = true;

    protected $fillable = [
        'judul_menu',
        'url',
        'icon'
    ];

    
}

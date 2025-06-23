<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'email',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

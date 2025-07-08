<?php
namespace App\Services\AuthServices;

use App\Models\User;

interface AuthServiceInterface{
    public function doLogin(string $email,string $password);
   
}

?>
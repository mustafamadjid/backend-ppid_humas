<?php
namespace App\Services\Implementation\Auth;

use App\Models\User;
use App\Services\AuthServices\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthServiceImpl implements AuthServiceInterface
{
    public function doLogin(User $user,string $password)
    {
        try {
           if(Hash::check($password,$user->password)){
            Log::info('Percobaan login berhasil',[
                'username' => $user->username,
                "time" => now()
            ]);
                return $user->createToken($user->username)->plainTextToken;
           }
           Log::warning('Percobaan login gagal (password salah)',[
            'username' => $user->username,
            "time" => now()
        ]);
           return false;
        } catch (\Exception $e) {
            Log::error('Percobaan login gagal (Masalah pada server)',["time" => now()]);
            throw $e;
        }
    }   
}

?>
<?php
namespace App\Services\Implementation;

use App\Models\User;
use App\Services\UserRegistrationServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRegistrationServiceImpl implements UserRegistrationServiceInterface{
    public function registerUser(array $data){
       
        try {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role']
            ]);

            Log::info("User baru berhasil diregistrasikan",[
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role'],
                "time" => now()
            ]);

            return $user;
            
        } catch (\Throwable $e) {
            Log::error("User baru gagal diregistrasikan",[
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role'],
                "time" => now()
            ]);
            throw $e;
        }
    }
}

?>
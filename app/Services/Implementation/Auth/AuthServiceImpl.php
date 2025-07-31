<?php
namespace App\Services\Implementation\Auth;

use App\Models\AktivitasTerbaru;
use App\Models\User;
use App\Services\AuthServices\AuthServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthServiceImpl implements AuthServiceInterface
{
    public function doLogin(string $email,string $password)
    {
        try {
            $user = User::where('email',$email)->firstOrFail();

           if(Hash::check($password,$user->password)){
            Log::info('Percobaan login berhasil',[
                'email' => $user->email,
                'role' => $user->role,
                "time" => now()->toDateTimeString()
            ]);
            AktivitasTerbaru::create([
                    'username' => $user->email,
                    'jenis_aktivitas' => 'login',
                    'deskripsi_aktivitas' => 'Berhasil Login',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);

                $token = $user->createToken($user->email)->plainTextToken;
                return [
                    "token" => $token,
                    "role" => $user->role,
                    "email" => $user->email,
                    "username" => $user->username
                ];
           }else{
               Log::warning('Percobaan login gagal (password tidak sesuai)',[
                'email' => $user->email,
                "time" => now()->toDateTimeString()   
            ]);
           }
           return false;
        }catch(ModelNotFoundException $e){
            Log::error('Percobaan login gagal (User tidak ditemukan)',["time" => now()->toDateTimeString()]);
            return false;
        } catch (\Throwable$e) {
            Log::error('Percobaan login gagal (Masalah pada server)',["time" => now()->toDateTimeString()]);
            throw $e;
        }
    }   
}

?>
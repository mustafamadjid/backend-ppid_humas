<?php 
namespace App\Services\Implementation;

use App\Models\User;
use App\Services\UserDataServiceInterface;
use Illuminate\Support\Facades\Log;

class UserDataServiceImpl implements UserDataServiceInterface
{
    public function getAllUserData(){
        try {
            $user = User::all();
            Log::info("Data semua user berhasil diambil",["time" => now()]);

            return $user;
        } catch (\Exception $e) {
            Log::error("Data semua user gagal diambil",["time" => now()]);
            throw $e;
        }
    }

    public function updateUserData(User $user, array $data){
        try {
            $user->update($data);
            Log::info("Data user berhasil diupdate",["time" => now()]);

            return $user;

        } catch (\Exception $e) {
            Log::error("Data user gagal diupdate",["time" => now()]);
            throw $e;
        }
    }

    public function deleteUserData(User $user){
        try {
            $user->delete();
            Log::info("Data user berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Exception $e) {
            Log::error("Data user gagal dihapus",["time" => now()]);
            throw $e;
        }
    }
}

?>
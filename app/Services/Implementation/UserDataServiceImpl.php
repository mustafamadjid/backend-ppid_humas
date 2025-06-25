<?php 
namespace App\Services\Implementation;

use App\Models\User;
use App\Services\UserDataServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserDataServiceImpl implements UserDataServiceInterface
{
    public function getAllUserData(){
        try {
            $user = User::all();
            Log::info("Data semua user berhasil diambil",["time" => now()]);

            return $user;
        } catch (\Throwable $th) {
            Log::error("Data semua user gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now(),
            ]);
            throw $th;
        }
    }

    public function updateUserData(User $user, array $data){
        try {
            $user->update($data);
            Log::info("Data user berhasil diupdate",["time" => now()]);

            return $user;

        } catch (\Throwable $th) {
            Log::error("Data user gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now(),
            ]);
            throw $th;
        }
    }

    public function deleteUserData(User $user){
        try {
            $user->delete();
            Log::info("Data user berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Throwable $th) {
            Log::error("Data user gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now(),
            ]);
            throw $th;
        }
    }
}

?>
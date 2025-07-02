<?php 
namespace App\Services\Implementation;

use App\Models\User;
use App\Services\DataServiceInterface;
use App\Services\UserDataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserDataServiceImpl implements DataServiceInterface
{

    public function createData(array $data){
       
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
            
        } catch (\Throwable $th) {
            Log::error("User baru gagal diregistrasikan",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now(),
            ]);
            throw $th;
        }
    }
    public function getData(){
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

    public function updateData(Model $user, array $data){
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

    public function deleteData(Model $user){
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
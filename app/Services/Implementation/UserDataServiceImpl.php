<?php 
namespace App\Services\Implementation;

use App\Models\User;
use App\Services\DataServiceInterface;
use App\Services\UserDataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

            Log::info("User baru berhasil diregistrasikan", [
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role'],
                "time" => now()->toDateTimeString()
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error("User baru gagal diregistrasikan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }

    public function getData(){
        try {
            $user = User::all();
            Log::info("Data semua user berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $user;
        } catch (\Throwable $th) {
            Log::error("Data semua user gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }

    public function updateData( $id, array $data){
        try {
            $user = User::findOrFail($id);

            $result = $user->update($data);
            Log::info("Data user berhasil diupdate", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        }catch (ModelNotFoundException $e) {
            Log::error("Data user gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data user gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }

    public function deleteData( $id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Log::info("Data user berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e) {
            Log::error("Data user gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data user gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }
}

?>

<?php 
namespace App\Services\Implementation;

use App\Models\User;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserDataServiceImpl implements DataServiceInterface
{
    public function createData(array $data, string $username)
    {
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
            // Catat aktivitas oleh admin/operator
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => "Menambahkan User: " . $data['username'],
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
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

    public function getData()
    {
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

    public function updateData($id, array $data, string $username)
    {
        try {
            $user = User::findOrFail($id);

            if(empty($data['password'])) {
                unset($data['password']);
                $result = $user->update($data);
            } else {
                $data['password'] = Hash::make($data['password']);
                $result = $user->update($data);
            }

            

            Log::info("Data user berhasil diupdate", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas oleh admin/operator
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'update',
                'deskripsi_aktivitas' => "Mengubah Data User: " . $user->username,
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data user gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data user gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            throw $th;
        }
    }

    public function deleteData($id, string $username)
    {
        try {
            $user = User::findOrFail($id);
            $usernameTarget = $user->username;
            $user->delete();

            Log::info("Data user berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas oleh admin/operator
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'delete',
                'deskripsi_aktivitas' => "Menghapus User: " . $usernameTarget,
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return true;
        } catch (ModelNotFoundException $e) {
            Log::error("Data user gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => now()->toDateTimeString(),
            ]);
            return false;
        } catch (\Throwable $th) {
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

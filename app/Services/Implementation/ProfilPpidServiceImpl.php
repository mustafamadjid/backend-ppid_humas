<?php
namespace App\Services\Implementation;

use App\Models\ProfilPpid;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProfilPpidServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = ProfilPpid::all();
            Log::info("Data profil ppid berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data profil ppid gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createData(array $data, string $username)
    {
        try {
            $result = ProfilPpid::create($data);
            Log::info("Data profil ppid berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Profil PPID',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data profil ppid gagal ditambahkan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function updateData($id, array $data, string $username)
    {
        try{
            $result = ProfilPpid::findOrFail($id);

            $update = $result->update($data);

            if ($update) {
                Log::info("Data profil ppid berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Profil PPID',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data profil ppid gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $update;
        }catch (ModelNotFoundException $e) {
            Log::error("Data profil ppid gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data profil ppid gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteData($id, string $username)
    {
        try {
            $data = ProfilPpid::findOrFail($id);
            $result = $data->delete();
            if ($result) {
                Log::info("Data profil ppid berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Profil PPID',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data profil ppid gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        }catch (ModelNotFoundException $e) {
            Log::error("Data profil ppid gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data profil ppid gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>

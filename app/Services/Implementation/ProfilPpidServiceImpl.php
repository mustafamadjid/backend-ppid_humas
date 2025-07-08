<?php
namespace App\Services\Implementation;

use App\Models\ProfilPpid;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

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

    public function createData(array $data)
    {
        try {
            $result = ProfilPpid::create($data);
            Log::info("Data profil ppid berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
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

    public function updateData($id, array $data)
    {
        try{
            $result = ProfilPpid::findOrFail($id);

            $data = $result->update($data);

            if ($data) {
                Log::info("Data profil ppid berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data profil ppid gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $data;
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

    public function deleteData($id)
    {
        try {
            $data = ProfilPpid::findOrFail($id);
            $result = $data->delete();
            Log::info("Data profil ppid berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
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
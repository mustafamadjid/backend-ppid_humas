<?php
namespace App\Services\Implementation;

use App\Models\Infografis;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class InfografisServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = Infografis::all();
            Log::info("Data infografis berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data infografis gagal diambil", [
                "time" => now()->toDateTimeString(),
                "error" => $th->getMessage()
            ]);
            throw $th;
        }
    }
    public function createData(array $data)
    {
        try {
            $result = Infografis::create($data);
            Log::info("Data infografis berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data infografis gagal ditambahkan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    public function updateData( $id, array $data)
    {
        try {
            $result = Infografis::findOrFail($id);
            $data = $result->update($data);
            if ($data) {
                Log::info("Data infografis berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data infografis gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $data;
        } catch (ModelNotFoundException $th) {
            Log::error("Data infografis tidak ditemukan", [
                "time" => now()->toDateTimeString(),
                "error" => $th->getMessage()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data infografis gagal diupdate", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
    public function deleteData(  $id)
    {
        try {
            $result = Infografis::findOrFail($id);
            $result->delete();
            Log::info("Data infografis berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            return true;
        } catch (ModelNotFoundException $th) {
            Log::error("Data infografis tidak ditemukan", [
                "time" => now()->toDateTimeString(),
                "error" => $th->getMessage()
            ]);
            return false;
        }catch (\Throwable $th) {
            Log::error("Data infografis gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
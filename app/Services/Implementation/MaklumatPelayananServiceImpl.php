<?php
namespace App\Services\Implementation;

use App\Models\MaklumatPelayanan;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MaklumatPelayananServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = MaklumatPelayanan::all();
            Log::info("Data maklumat pelayanan berhasil diambil", [
            "count" => $data->count(),
            "time" => now()
        ]);
        return $data;
        } catch (\Throwable $th) {
            Log::error("Data maklumat pelayanan gagal diambil",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function createData(array $data)
    {
        try{
            $result = MaklumatPelayanan::create($data);
            Log::info("Data maklumat pelayanan berhasil ditambahkan");
            return $result;
        }catch (\Throwable $th){
            Log::error("Gagal menambahkan data maklumat pelayanan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
    public function updateData(Model $maklumat,array $data)
    {
        try {
            $result = $maklumat->update($data);
            if ($result) {
                Log::info("Data maklumat pelayanan berhasil diupdate", ["time" => now()]);
            } else {
                Log::warning("Data maklumat pelayanan gagal diupdate (tidak ada perubahan di database)", ["time" => now()]);
            }
            return $result;
            
        } catch (\Throwable $th) {
            Log::error("Gagal update data maklumat pelayanan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
    public function deleteData(Model $maklumat){
        try {
            $result = $maklumat->delete();
            if ($result) {
                Log::info("Data maklumat pelayanan berhasil dihapus", ["time" => now()]);
            } else {
                Log::warning("Data maklumat pelayanan gagal dihapus (tidak ada perubahan di database)", ["time" => now()]);
            }
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data maklumat pelayanan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now(),
            ]);
            throw $th;
        }
    }
}
?>
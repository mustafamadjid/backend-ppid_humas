<?php 
namespace App\Services\Implementation;

use App\Models\SematanAplikasi;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class SematanAplikasiImpl implements DataServiceInterface
{
   public function getData()
   {
    try {
        $data = SematanAplikasi::all();
        Log::info("Data sematan aplikasi berhasil diambil", [
            "time" => now()->toDateTimeString()
        ]);
        return $data;
    } catch (\Throwable $th) {
       Log::error("Data sematan aplikasi gagal diambil", [
           'error' => $th->getMessage(),
           'trace' => $th->getTraceAsString(),
           "time" => now()->toDateTimeString()
       ]);
    }
   }
   public function createData(array $data)
   {
    try { 
        $result = SematanAplikasi::create($data);
        Log::info("Data sematan aplikasi berhasil ditambahkan", [
            "time" => now()->toDateTimeString()
        ]);
        return $result;
    } catch (\Throwable $th) {
        Log::error("Data sematan aplikasi gagal ditambahkan", [
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
        $result = SematanAplikasi::findOrFail($id);
        $data = $result->update($data);

        if($data){
            Log::info("Data sematan aplikasi berhasil diupdate", [
                "time" => now()->toDateTimeString()
            ]);
        }else{
            Log::error("Data sematan aplikasi gagal diupdate", [
                "time" => now()->toDateTimeString()
            ]);
        }
        return $data;
    } catch(ModelNotFoundException $th){
        Log::error("Data sematan aplikasi tidak ditemukan", [
            'error' => $th->getMessage(),
            'trace' => $th->getTraceAsString(),
            "time" => now()->toDateTimeString()
        ]);
        return false;
    } catch (\Throwable $th) {
        Log::error("Data sematan aplikasi gagal diupdate", [
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
        $result = SematanAplikasi::findOrFail($id);
        $data = $result->delete();

        if($data){
            Log::info("Data sematan aplikasi berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
        }else{
            Log::error("Data sematan aplikasi gagal dihapus", [
                "time" => now()->toDateTimeString()
            ]);
        }
       
        return $data;
    } catch (\Throwable $th) {
        Log::error("Data sematan aplikasi gagal dihapus", [
            'error' => $th->getMessage(),
            'trace' => $th->getTraceAsString(),
            "time" => now()->toDateTimeString()
        ]);
        throw $th;
    }
   }
}
?>
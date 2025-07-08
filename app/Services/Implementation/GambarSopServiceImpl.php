<?php
namespace App\Services\Implementation;

use App\Models\GambarSop;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GambarSopServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = GambarSop::all();
            Log::info("Data gambar SOP berhasil diambil",[
                "count" => $data->count(),
                "time" => now()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal diambil",[
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
            $result = GambarSop::create($data);
            Log::info("Data gambar SOP berhasil ditambahkan",[
                "time" => now()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal ditambahkan",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function updateData($id, array $data)
    {
        try {
            $dataGambar = GambarSop::findOrFail($id);

            $result = $dataGambar->update($data);
            if ($result) {
                Log::info("Data gambar SOP berhasil diupdate",[
                    "time" => now()
                ]);
            }else{
                Log::warning("Data gambar SOP gagal diupdate (tidak ada perubahan di database)",[
                    "time" => now()
                ]);
            }
            return $result;
        }catch(ModelNotFoundException $e){
            Log::error("Data gambar SOP gagal diupdate",[
                'id' => $object->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal diupdate",[
                'id' => $object->id ?? null,
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
            $dataGambar = GambarSop::findOrFail($id);

            if ($dataGambar->path_gambar && Storage::disk('public')->exists($dataGambar->path_gambar)) {
                Storage::disk('public')->delete($dataGambar->path_gambar);
            }

            $result = $dataGambar->delete();
            if ($result) {
                Log::info("Data gambar SOP berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar SOP gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar SOP gagal dihapus", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal dihapus", [
                'id' => $id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

}

?>
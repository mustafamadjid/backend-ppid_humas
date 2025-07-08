<?php
namespace App\Services\Implementation;

use App\Models\BannerBeranda;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerBerandaImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = BannerBeranda::all();
            Log::info("Data gambar banner beranda berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal diambil", [
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
            $result = BannerBeranda::create($data);
            Log::info("Data gambar banner beranda berhasil dibuat", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal dibuat", [
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
            $banner = BannerBeranda::findOrFail($id);
            $result = $banner->update($data);
    
            if ($result) {
                Log::info("Data gambar banner beranda berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar banner beranda gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar banner beranda tidak ditemukan untuk update", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal diupdate", [
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
            $banner = BannerBeranda::findOrFail($id);
    
            if (Storage::disk('public')->exists($banner->path_gambar)) {
                Storage::disk('public')->delete($banner->path_gambar);
            }
    
            $result = $banner->delete();
            if ($result) {
                Log::info("Data gambar banner beranda berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar banner beranda gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar banner beranda tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal dihapus", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

}
?>

<?php
namespace App\Services\Implementation;

use App\Models\BannerBeranda;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BannerBerandaImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = BannerBeranda::all();
            Log::info("Data gambar banner beranda berhasil diambil",[
                "count" =>$data->count(),
                "time" => now()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal diambil",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }

    public function createData(array $data)
    {
       try {
        $result = BannerBeranda::create($data);
        Log::info("Data gambar banner beranda berhasil dibuat");
        return $result;
       } catch (\Throwable $th) {
        Log::error("Data gambar banner beranda gagal dibuat",[
            'error' => $th->getMessage(),
            'trace' => $th->getTraceAsString()
        ]);
        throw $th;
       }
    }

    public function updateData(Model $banner, array $data)
    {
        try {
            $result = $banner->update($data);
            if($result){
                Log::info("Data gambar banner beranda berhasil diupdate");
            }else{
                Log::warning("Data gambar banner beranda gagal diupdate (tidak ada perubahan di database)", ["time" => now()]);
            }
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal diupdate",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }

    public function deleteData(Model $banner)
    {
        try {
            $result = $banner->delete();
            if($result){
                Log::info("Data gambar banner beranda berhasil dihapus");
            }else{
                Log::warning("Data gambar banner beranda gagal dihapus (tidak ada perubahan di database)", ["time" => now()]);
            }
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal dihapus",[
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }

}
?>
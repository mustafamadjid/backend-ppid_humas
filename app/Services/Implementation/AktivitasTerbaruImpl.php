<?php
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Services\AktivitasTerbaruInterface;
use Illuminate\Support\Facades\Log;

class AktivitasTerbaruImpl implements AktivitasTerbaruInterface
{
    public function getData()
    {
        try{
            $data = AktivitasTerbaru::all();
            Log::info("Data aktivitas terbaru berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        }catch(\Throwable $th){
            Log::error("Data aktivitas terbaru gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}

?>
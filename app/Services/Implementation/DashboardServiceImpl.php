<?php
namespace App\Services\Implementation;

use App\Models\DokumenPublik;
use App\Models\FormKeberatan;
use App\Models\FormPengaduan;
use App\Models\FormPermohonanInformasi;
use App\Models\User;
use App\Services\DashboardServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DashboardServiceImpl implements DashboardServiceInterface
{
    public function countDokumen(){
        try {
            $count = DokumenPublik::count();
            Log::info("Total data dokumen berhasil diambil", [
                "count" => $count,
                "time" => now()->toDateTimeString()
            ]);
            return $count;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total data dokumen", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
        }
    }
    public function countFormPengaduan(){
        try{
            $count = FormPengaduan::count();
                Log::info("Total data form pengaduan berhasil diambil", [
                    "count" => $count,
                    "time" => now()->toDateTimeString()
                ]);
                return $count;
        }catch(\Throwable $th){
            Log::error("Gagal ambil total data form pengaduan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
        }
    }
    public function countFormPengajuan(){
        try {
            $count = FormKeberatan::count();
            Log::info("Total data form pengajuan berhasil diambil", [
                "count" => $count,
                "time" => now()->toDateTimeString()
            ]);
            return $count;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total data form pengajuan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
        }
    }
    public function countFormPermohonan(){
        try {
            $count = FormPermohonanInformasi::count();
            Log::info("Total data form permohonan berhasil diambil", [
                "count" => $count,
                "time" => now()->toDateTimeString()
            ]);
            return $count;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total data form permohonan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
        }
    }
    public function countAdmin(){
        try {
            $count = User::count();
            Log::info("Total data admin berhasil diambil", [
                "count" => $count,
                "time" => now()->toDateTimeString()
            ]);
            return $count;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total data admin", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
        }
    }

    public function countStatusForm(Model $model)
    {
        try {
            $countTotalForm = $model::count();
            $countBelumDiproses = $model::where('status','belum_diproses')->count();
            $countSedangDiproses = $model::where('status','sedang_diproses')->count();
            $countSelesai = $model::where('status','selesai')->count();

            Log::info("Total data form pengajuan berhasil diambil", [
                
                "belum_diproses" => $countBelumDiproses,
                "sedang_diproses" => $countSedangDiproses,
                "selesai" => $countSelesai,
                "time" => now()->toDateTimeString()
            ]);

            return [
                'total' => $countTotalForm,
                'belum_diproses' => $countBelumDiproses,
                'sedang_diproses' => $countSedangDiproses,
                'selesai' => $countSelesai
            ];
        } catch (\Throwable $th) {
            Log::error("Gagal ambil total data form pengajuan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}

?>
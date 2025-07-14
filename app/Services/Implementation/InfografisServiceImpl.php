<?php
namespace App\Services\Implementation;

use App\Models\Infografis;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

    public function createData(array $data, string $username)
    {
        try {
            $result = Infografis::create($data);
            Log::info("Data infografis berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Infografis',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
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

    public function updateData($id, array $data, string $username)
    {
        try {
            $result = Infografis::findOrFail($id);
            $update = $result->update($data);
            if ($update) {
                Log::info("Data infografis berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
                // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Infografis',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data infografis gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $update;
        } catch (ModelNotFoundException $th) {
            Log::error("Data infografis tidak ditemukan", [
                "time" => now()->toDateTimeString(),
                "error" => $th->getMessage()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data infografis gagal diupdate", [
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
            $result = Infografis::findOrFail($id);
            $delete = $result->delete();
            if ($delete) {
                Log::info("Data infografis berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
                // Catat aktivitas
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Infografis',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data infografis gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $delete;
        } catch (ModelNotFoundException $th) {
            Log::error("Data infografis tidak ditemukan", [
                "time" => now()->toDateTimeString(),
                "error" => $th->getMessage()
            ]);
            return false;
        } catch (\Throwable $th) {
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

<?php
namespace App\Services\Implementation;

use App\Models\GambarSop;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GambarSopServiceImpl implements DataServiceInterface
{
    public function getData()
    {
        try {
            $data = GambarSop::all();
            Log::info("Data gambar SOP berhasil diambil", [
                "count" => $data->count(),
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal diambil", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createData(array $data, string $username)
    {
        try {
            $result = GambarSop::create($data);
            Log::info("Data gambar SOP berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Gambar SOP',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal ditambahkan", [
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
            $dataGambar = GambarSop::findOrFail($id);

            $result = $dataGambar->update($data);
            if ($result) {
                Log::info("Data gambar SOP berhasil diupdate", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Gambar SOP',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar SOP gagal diupdate (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar SOP gagal diupdate", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar SOP gagal diupdate", [
                'id' => $id,
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
            $dataGambar = GambarSop::findOrFail($id);

            // Hapus file gambar jika ada
            if ($dataGambar->path_gambar && Storage::disk('public')->exists($dataGambar->path_gambar)) {
                Storage::disk('public')->delete($dataGambar->path_gambar);
            }

            $result = $dataGambar->delete();
            if ($result) {
                Log::info("Data gambar SOP berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Gambar SOP',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
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

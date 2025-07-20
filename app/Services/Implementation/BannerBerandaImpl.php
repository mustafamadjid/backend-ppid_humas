<?php
namespace App\Services\Implementation;

use App\Models\AktivitasTerbaru;
use App\Models\BannerBeranda;
use App\Services\DataServiceInterface;
use Carbon\Carbon;
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

    public function createData(array $data, string $username)
    {
        try {
            $result = BannerBeranda::create($data);

            Log::info("Data gambar banner beranda berhasil dibuat", [
                "data" => $data,
                "username" => $username,
                "data_id" => $result->id ?? null,
                "time" => now()->toDateTimeString()
            ]);

            // Aktivitas Terbaru
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Banner Beranda',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal dibuat", [
                'username' => $username,
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
            $banner = BannerBeranda::findOrFail($id);
            $result = $banner->update($data);

            if ($result) {
                Log::info("Data gambar banner beranda berhasil diupdate", [
                    "data" => $data,
                    "username" => $username,
                    "data_id" => $id,
                    "time" => now()->toDateTimeString()
                ]);

                // Aktivitas Terbaru
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'update',
                    'deskripsi_aktivitas' => 'Mengubah Banner Beranda',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar banner beranda gagal diupdate (tidak ada perubahan di database)", [
                    "username" => $username,
                    "data_id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar banner beranda tidak ditemukan untuk update", [
                "username" => $username,
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal diupdate", [
                'username' => $username,
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
            $banner = BannerBeranda::findOrFail($id);

            if (Storage::disk('public')->exists($banner->path_gambar)) {
                Storage::disk('public')->delete($banner->path_gambar);
            }

            $result = $banner->delete();
            if ($result) {
                Log::info("Data gambar banner beranda berhasil dihapus", [
                    "username" => $username,
                    "data_id" => $id,
                    "time" => now()->toDateTimeString()
                ]);

                // Aktivitas Terbaru
                AktivitasTerbaru::create([
                    'username' => $username,
                    'jenis_aktivitas' => 'delete',
                    'deskripsi_aktivitas' => 'Menghapus Banner Beranda',
                    'waktu_aktivitas' => Carbon::now()->toDateTimeString()
                ]);
            } else {
                Log::warning("Data gambar banner beranda gagal dihapus (tidak ada perubahan di database)", [
                    "username" => $username,
                    "data_id" => $id,
                    "time" => now()->toDateTimeString()
                ]);
            }
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data gambar banner beranda tidak ditemukan untuk dihapus", [
                "username" => $username,
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Data gambar banner beranda gagal dihapus", [
                'username' => $username,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>

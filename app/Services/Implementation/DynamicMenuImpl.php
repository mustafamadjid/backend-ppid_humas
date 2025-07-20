<?php 
namespace App\Services\Implementation;

use App\Models\DynamicMenu;
use App\Models\AktivitasTerbaru;
use App\Services\DataServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DynamicMenuImpl implements DataServiceInterface
{
    public function createData(array $data, string $username)
    {
        try {
            $menu = DynamicMenu::create($data);
            Log::info("Data menu berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'create',
                'deskripsi_aktivitas' => 'Menambahkan Menu Dinamis',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $menu;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal ditambahkan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $e;
        }
    }

    public function getData()
    {
        try {
            $menu = DynamicMenu::all();
            Log::info("Data menu berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return $menu;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data menu", [
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
            $menu = DynamicMenu::findOrFail($id);
            $result = $menu->update($data);
            Log::info("Data menu berhasil diupdate", [
                "data" => $data,
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'update',
                'deskripsi_aktivitas' => 'Mengubah Menu Dinamis',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return $result;
        } catch (ModelNotFoundException $e) {
            Log::error("Data menu gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $e;
        }
    }

    public function deleteData($id, string $username)
    {
        try {
            $menu = DynamicMenu::findOrFail($id);
            $menu->delete();
            Log::info("Data menu berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            // Catat aktivitas
            AktivitasTerbaru::create([
                'username' => $username,
                'jenis_aktivitas' => 'delete',
                'deskripsi_aktivitas' => 'Menghapus Menu Dinamis',
                'waktu_aktivitas' => Carbon::now()->toDateTimeString()
            ]);
            return true;
        } catch (ModelNotFoundException $e) {
            Log::error("Data menu gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $e;
        }
    }
}
?>

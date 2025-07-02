<?php 
namespace App\Services\Implementation;

use App\Models\DynamicMenu;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DynamicMenuImpl implements DataServiceInterface
{
    public function createData(array $data){
        try {
            $menu = DynamicMenu::create([
                'judul_menu' => $data['judul_menu'],
                'url' => $data['url'],
            ]);
            Log::info("Data menu berhasil ditambahkan",["time" => now()]);
            return $menu;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal ditambahkan",["time" => now()]);
            throw $e;
        }
    }
    public function getData()
    {
        try {
            $menu = DynamicMenu::all();
            Log::info("Data menu berhasil diambil",["time" => now()]);
            return $menu;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data menu", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function updateData(Model $menu,array $data)
    {
        try {
            $menu->update($data);
            Log::info("Data menu berhasil diupdate",["time" => now()]);
            return $menu;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal diupdate", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    public function deleteData(Model $menu)
    {
        try {
            $menu->delete();
            Log::info("Data menu berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Throwable $e) {
            Log::error("Data menu gagal dihapus", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}


?>
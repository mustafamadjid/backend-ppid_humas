<?php 
namespace App\Services\Implementation;

use App\Models\DynamicMenu;
use App\Services\DynamicMenuInterface;
use Illuminate\Support\Facades\Log;

class DynamicMenuImpl implements DynamicMenuInterface
{
    public function createDynamicMenu(array $data){
        try {
            $menu = DynamicMenu::create([
                'judul_menu' => $data['judul_menu'],
                'url' => $data['url'],
            ]);
            Log::info("Data menu berhasil ditambahkan",["time" => now()]);
            return $menu;
        } catch (\Exception $e) {
            Log::error("Data menu gagal ditambahkan",["time" => now()]);
            throw $e;
        }
    }
    public function getDynamicMenu()
    {
        try {
            $menu = DynamicMenu::all();
            Log::info("Data menu berhasil diambil",["time" => now()]);
            return $menu;
        } catch (\Exception $e) {
            Log::error("Data menu gagal diambil",["time" => now()]);
            throw $e;
        }
    }

    public function updateDynamicMenu(DynamicMenu $menu,array $data)
    {
        try {
            $menu->update($data);
            Log::info("Data menu berhasil diupdate",["time" => now()]);
            return $menu;
        } catch (\Exception $e) {
            Log::error("Data menu gagal diupdate",["time" => now()]);
            throw $e;
        }
    }

    public function deleteDynamicMenu(DynamicMenu $menu)
    {
        try {
            $menu->delete();
            Log::info("Data menu berhasil dihapus",["time" => now()]);
            return true;
        } catch (\Exception $e) {
            Log::error("Data menu gagal dihapus",["time" => now()]);
            throw $e;
        }
    }
}


?>
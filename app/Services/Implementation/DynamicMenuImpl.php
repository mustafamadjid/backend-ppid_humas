<?php 
namespace App\Services\Implementation;

use App\Models\DynamicMenu;
use App\Services\DataServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DynamicMenuImpl implements DataServiceInterface
{
    public function createData(array $data){
        try {
            $menu = DynamicMenu::create([
                'judul_menu' => $data['judul_menu'],
                'url' => $data['url'],
            ]);
            Log::info("Data menu berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
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

    public function updateData($id, array $data)
    {
        try {
            $menu = DynamicMenu::findOrFail($id);
           $result =  $menu->update($data);
            Log::info("Data menu berhasil diupdate", [
                "time" => now()->toDateTimeString()
            ]);
            return $result;
        }catch (ModelNotFoundException $e){
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

    public function deleteData($id)
{
    try {
        $menu = DynamicMenu::findOrFail($id);
        $menu->delete();
        Log::info("Data menu berhasil dihapus", [
            "time" => now()->toDateTimeString()
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

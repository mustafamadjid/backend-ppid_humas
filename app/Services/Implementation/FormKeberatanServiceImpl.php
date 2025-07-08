<?php
namespace App\Services\Implementation;

use App\Models\FormKeberatan;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormKeberatanServiceImpl implements FormServiceInterface
{
    public function getForm()
    {
        try {
            Log::info('Data form keberatan berhasil diambil', [
                'time' => now()->toDateTimeString()
            ]);
            return FormKeberatan::all();
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createForm(array $data)
    {
        try {
            Log::info('Data form keberatan berhasil ditambahkan', [
                'time' => now()->toDateTimeString()
            ]);
            return FormKeberatan::create($data);
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteForm($id)
    {
        try {
            $form = FormKeberatan::findOrFail($id);

            if ($form->path_file_bukti && Storage::disk('public')->exists($form->path_file_bukti)) {
                Storage::disk('public')->delete($form->path_file_bukti);
            }
            $result = $form->delete();
            
            if($result){
                Log::info("Data form keberatan berhasil dihapus", [
                    "time" => now()->toDateTimeString()
                ]);
            }else{
                Log::warning("Data form keberatan gagal dihapus (tidak ada perubahan di database)", [
                    "time" => now()->toDateTimeString()
                ]);
            }

            Log::info('Data form keberatan berhasil dihapus', [
                'time' => now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form keberatan tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus data form keberatan", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>

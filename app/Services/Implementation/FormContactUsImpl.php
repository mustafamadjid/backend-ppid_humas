<?php 
namespace App\Services\Implementation;

use App\Models\FormContactUs;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class FormContactUsImpl implements FormServiceInterface
{
    public function getForm()
    {
        try {
            $result = FormContactUs::all();
            Log::info('Data form contact us berhasil diambil', [
                'time' => now()->toDateTimeString()
            ]);
            return $result;
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form contact us", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'time' => now()->toDateTimeString()
            ]);
            throw $th;  
        }
    }

    public function createForm(array $data)
    {
        try{
            $data = FormContactUs::create($data);
            Log::info('Data form contact us berhasil ditambahkan', [
                'time' => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data form contact us", [
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
            $form = FormContactUs::findOrFail($id);
            $form->delete();
            Log::info("Data form contact us berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form contact us tidak ditemukan untuk dihapus", [
                "id_form" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data form contact us", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>
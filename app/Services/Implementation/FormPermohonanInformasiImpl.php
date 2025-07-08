<?php 
namespace App\Services\Implementation;

use App\Models\FormPermohonanInformasi;
use App\Services\FormServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class FormPermohonanInformasiImpl implements FormServiceInterface
{
    public function getForm(){
        try {
            Log::info("Data form permohonan informasi berhasil diambil", [
                "time" => now()->toDateTimeString()
            ]);
            return FormPermohonanInformasi::all();
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function createForm(array $data){
        try {
            $data = FormPermohonanInformasi::create($data);
            Log::info("Data form permohonan informasi berhasil ditambahkan", [
                "time" => now()->toDateTimeString()
            ]);
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal tambah data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }

    public function deleteForm($id){
        try {
            $form = FormPermohonanInformasi::findOrFail($id);
            $form->delete();
            Log::info("Data form permohonan informasi berhasil dihapus", [
                "time" => now()->toDateTimeString()
            ]);
            return true;
        }catch (ModelNotFoundException $e){
            Log::error("Data form permohonan informasi tidak ditemukan untuk dihapus", [
                "id" => $id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            return false;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                "time" => now()->toDateTimeString()
            ]);
            throw $th;
        }
    }
}
?>

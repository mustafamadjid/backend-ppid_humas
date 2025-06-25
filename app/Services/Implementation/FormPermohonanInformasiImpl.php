<?php 
namespace App\Services\Implementation;

use App\Models\FormPermohonanInformasi;
use App\Services\FormPermohonanInformasiInterface;
use Illuminate\Support\Facades\Log;

class FormPermohonanInformasiImpl implements FormPermohonanInformasiInterface
{
    public function getAllFormPermohonanInformasi(){
        try {
            Log::info("Data form permohonan informasi berhasil diambil");
            return FormPermohonanInformasi::all();
        } catch (\Throwable $th) {
            Log::error("Gagal ambil data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function createFormPermohonanInformasi(array $data){
        try {
            $data = FormPermohonanInformasi::create($data);
            Log::info("Data form permohonan informasi berhasil ditambahkan");
            return $data;
        } catch (\Throwable $th) {
            Log::error("Gagal tambah data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function deleteFormPermohonanInformasi(FormPermohonanInformasi $form){
        try {
            $form->delete();
            Log::info("Data form permohonan informasi berhasil dihapus");
            return true;
        } catch (\Throwable $th) {
            Log::error("Gagal hapus data form permohonan informasi", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}

?>
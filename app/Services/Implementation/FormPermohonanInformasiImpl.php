<?php 
namespace App\Services\Implementation;

use App\Models\FormPermohonanInformasi;
use App\Services\FormPermohonanInformasiInterface;
use App\Services\FormPermohonanInfromasiInterface;
use Illuminate\Support\Facades\Log;

class FormPermohonanInformasiImpl implements FormPermohonanInformasiInterface
{
    public function getAllFormPermohonanInformasi(){
        try {
            Log::info("Data form permohonan informasi berhasil diambil");
            return FormPermohonanInformasi::all();
        } catch (\Throwable $e) {
            Log::error("Data form permohonan informasi gagal diambil");
            throw $e;
        }
    }

    public function createFormPermohonanInformasi(array $data){
        try {
            $data = FormPermohonanInformasi::create($data);
            Log::info("Data form permohonan informasi berhasil ditambahkan");
            return $data;
        } catch (\Throwable $e) {
            Log::error("Data form permohonan informasi gagal ditambahkan");
            throw $e;
        }
    }

    public function deleteFormPermohonanInformasi(FormPermohonanInformasi $form){
        try {
            $form->delete();
            Log::info("Data form permohonan informasi berhasil dihapus");
            return true;
        } catch (\Throwable $e) {
            Log::error("Data form permohonan informasi gagal dihapus");
            throw $e;
        }
    }
}


?>
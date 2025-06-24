<?php 
namespace App\Services;

use App\Models\FormPermohonanInformasi;

interface FormPermohonanInformasiInterface{
    public function getAllFormPermohonanInformasi();
    public function createFormPermohonanInformasi(array $data);
    public function deleteFormPermohonanInformasi(FormPermohonanInformasi $form);
}

?>
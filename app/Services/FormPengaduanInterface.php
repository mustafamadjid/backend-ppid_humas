<?php 
namespace App\Services;

use App\Models\FormPengaduan;

interface FormPengaduanInterface
{
    public function createFormPengaduan(array $data);
    public function getFormPengaduan();
    public function deleteFormPengaduan(FormPengaduan $pengaduan);
}


?>
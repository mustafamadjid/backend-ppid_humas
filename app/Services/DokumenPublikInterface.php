<?php
namespace App\Services;

use App\Models\DokumenPublik;

interface DokumenPublikInterface
{
    public function getDokumenPublik();
    public function createDokumenPublik(array $data);
    public function updateDokumenPublik(DokumenPublik $dokumen,array $data);
    public function deleteDokumenPublik(DokumenPublik $dokumen);
}


?>
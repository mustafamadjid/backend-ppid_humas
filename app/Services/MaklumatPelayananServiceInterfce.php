<?php
namespace App\Services;

use App\Models\MaklumatPelayanan;

interface MaklumatPelayananServiceInterfce 
{
    public function getMaklumatPelayanan();
    public function createMaklumatPelayanan(array $data);
    public function updateMaklumatPelayanan(MaklumatPelayanan $maklumat,array $data);
    public function deleteMaklumatPelayanan(MaklumatPelayanan $maklumat);
}

?>
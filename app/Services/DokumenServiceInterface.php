<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DokumenServiceInterface
{
    public function getData();
    public function getDataByTahun(int $tahun,string $kategori);
    public function createData(array $data);
    public function updateData($id, array $data);
    public function deleteData($id);
}

?>
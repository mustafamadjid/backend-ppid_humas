<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DokumenServiceInterface
{
    public function getData();
    public function getDataByTahun(int $tahun,string $kategori);
    public function getDataByKategori(string $kategori);
    public function createData(array $data, string $username);
    public function updateData($id, array $data, string $username);
    public function deleteData($id, string $username);
}

?>
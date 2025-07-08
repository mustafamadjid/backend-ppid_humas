<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DeskripsiHalamanDokumenInterface{
    public function getData();
    public function getDataByKategori(string $kategori);
    public function createData(array $data);
    public function updateData(int $id, array $data);
    public function deleteData(int $id);
}
?>
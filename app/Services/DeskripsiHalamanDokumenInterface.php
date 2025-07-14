<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DeskripsiHalamanDokumenInterface{
    public function getData();
    public function getDataByKategori(string $kategori);
    public function createData(array $data, string $username);
    public function updateData( $id, array $data, string $username);
    public function deleteData( $id, string $username);
}
?>
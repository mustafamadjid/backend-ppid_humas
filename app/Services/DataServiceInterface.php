<?php
namespace App\Services;


interface DataServiceInterface 
{
    public function getData();
    public function createData(array $data,string $username);
    public function updateData( $id, array $data,string $username);
    public function deleteData($id,string $username);
}

?>
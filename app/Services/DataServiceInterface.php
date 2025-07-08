<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface DataServiceInterface 
{
    public function getData();
    public function createData(array $data);
    public function updateData( $id, array $data);
    public function deleteData(  $id);
}

?>
<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface FormServiceInterface
{
    public function getForm();
    public function createForm(array $data,);

     public function updateForm($id, array $data, string $username);
    public function deleteForm($id);
}

?>
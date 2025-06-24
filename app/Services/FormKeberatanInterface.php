<?php
namespace App\Services;

use App\Models\FormKeberatan;

interface FormKeberatanInterface {
    public function getAllFormKeberatan();
    // public function getFormKeberatanById($id);
    public function createFormKeberatan(array $data);
    public function deleteFormKeberatan(FormKeberatan $form);
}


?>
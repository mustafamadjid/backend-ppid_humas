<?php
namespace App\Services;

use App\Models\DynamicMenu; 

interface DynamicMenuInterface
{
    public function createDynamicMenu(array $data);
    public function getDynamicMenu();
    public function updateDynamicMenu(DynamicMenu $menu,array $data);

    public function deleteDynamicMenu(DynamicMenu $menu);
}

?>
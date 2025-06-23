<?php
namespace App\Services;

use App\Models\User;

interface UserDataServiceInterface
{
    public function getAllUserData();
    public function updateUserData(User $user, array $data);
    public function deleteUserData(User $user);
}

?>
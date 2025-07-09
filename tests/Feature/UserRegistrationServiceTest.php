<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserRegistrationServiceTest extends TestCase
{
    public function userToken (){
        $user =  User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        return $token;
    }

    public function userTokenWithId($id){
        $user =  User::factory()->create(['id' => $id]);
        $token = $user->createToken('admin')->plainTextToken;

        return $token;
    }


    // Super admin account
    // token : 25|efM5P68RBEMG7CaJPAH1swZuXgr5GME2bHVnqEBUb5fac790
    // username : superadmin
    // password : superadmin123

    public function test_superadmin_registerUserResponse(){
        

        $data = [
            'username' => 'admingacor',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'role' => 'superadmin'
        ];

        $this->post('/register', $data)
            ->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'User baru berhasil diregistrasikan',
                'data' => [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'role' => $data['role']
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role']
        ]);
    }

    public function test_registerUser_username_duplicate(){
         

        $data = [
            'username' => 'adimas',
            'email' => 'xxxx@example',
            'password' => 'rolerosssf',
            'role' => 'admin'
        ];

        $this->withHeader('Authorization', 'Bearer 25|efM5P68RBEMG7CaJPAH1swZuXgr5GME2bHVnqEBUb5fac790')->post('/ppid/user/register', $data)
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'User baru gagal diregistrasikan',
                'errors' => [
                    'username' => ['The username has already been taken.']
                ]
            ]);
    }
}

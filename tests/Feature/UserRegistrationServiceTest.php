<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserRegistrationServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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


    public function test_registerUserResponse(){
        

        $data = [
            'username' => 'lkh',
            'email' => 'lkhs@example',
            'password' => 'suanrman',
            'role' => 'admin'
        ];

        $this->withHeader('Authorization', 'Bearer '. $this->userToken())->post('/ppid/user/register', $data)
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

        $this->withHeader('Authorization', 'Bearer '. $this->userToken())->post('/ppid/user/register', $data)
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

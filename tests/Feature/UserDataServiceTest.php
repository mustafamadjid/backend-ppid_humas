<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserDataServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDataServiceTest extends TestCase
{

    public function userToken()
    {
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        return $token;
    }

    public function userTokenWithId($id)
    {
        $user = User::factory()->create(['id_user' => $id]);
        $token = $user->createToken('admin')->plainTextToken;

        return $token;
    }

    public function test_getAllUserData(): void
    {
        $token = $this->userToken();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/ppid/user/');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }

    public function test_fail_getAllUserData(): void
    {
        // No token provided
        $response = $this->get('/ppid/user/');
        $response->assertStatus(500);
    }

    public function test_updateUserData(): void
    {
        $token = $this->userTokenWithId(100);

        $this->withHeader('Authorization', 'Bearer ' . $token)->put('/ppid/user/100', [
            'username' => 'lorenzo',
            'email' => 'lorenzo@example',
            'role' => 'admin'
        ]);

        $this->assertDatabaseHas('users', [
            'id_user' => 100,
            'username' => 'lorenzo',
            'email' => 'lorenzo@example',
            'role' => 'admin'
        ]);
    }

    public function test_fail_validation_updateUserData(): void
    {
        $token = $this->userTokenWithId(200);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put('/ppid/user/200', [
                'username' => 120,
                'email' => 'lorenzo@example',
                'role' => 'admin'
            ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Data user gagal diupdate',
                'errors' => [
                    'username' => [
                        'The username field must be a string.'
                    ]
                ]
            ]);
    }

    public function test_fail_id_exception_updateUserData(): void
    {
        $token = $this->userToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put('/ppid/user/1000', [
                'username' => 'lorenzo',
                'email' => 'lorenzo@example',
                'role' => 'admin'
            ])
            ->assertStatus(404)
            ->assertJson([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ]);
    }

    public function test_deleteUserData(): void
    {
        $token = $this->userTokenWithId(8);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/ppid/user/8')
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data user berhasil dihapus'
            ]);

        $this->assertDatabaseMissing('users', ['id_user' => 8]);
    }

    public function test_fail_id_exception_deleteUserData(): void
    {
        $token = $this->userToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/ppid/user/10003')
            ->assertStatus(404)
            ->assertJson([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ]);
    }

    
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\DynamicMenuInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertJson;

class DynamicMenuServiceTest extends TestCase
{

    public function test_getDynamicMenu(){
        $user = User::factory()->create();
       
        $token = $user->createToken('admin')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)->get('/ppid/menu-beranda')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_empty_getDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->get('/ppid/menu-beranda')
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data semua menu berhasil diambil',
                'data' => []
            ]);
    }

    public function test_createDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 'Menu Baru',
            'url' => 'https://google.com'
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->post('/ppid/menu-beranda', $data)
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data menu berhasil ditambahkan',
                'data' => $data
            ]);

        $this->assertDatabaseHas('menu_dinamis_beranda', $data);
    }

    public function test_fail_validation_type_createDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 120,
            'url' => 'https://google.com'
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->post('/ppid/menu-beranda', $data)
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Data menu gagal ditambahkan',
                'errors' => [
                    'judul_menu' => [
                        'The judul menu field must be a string.'
                    ]
                ]
            ]);
    }

    public function test_fail_validation_missingField_createDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 'Menu Baru',
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->post('/ppid/menu-beranda', $data)
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Data menu gagal ditambahkan',
                'errors' => [
                    'url' => [
                        'The url field is required.'
                    ]
                ]
            ]);
    }

    public function test_updateDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 'Menu modified',
            'url' => 'https://amazon.com'
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->put('/ppid/menu-beranda/4', $data)
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data menu berhasil diupdate',
                'data' => $data
            ]);

        $this->assertDatabaseHas('menu_dinamis_beranda', $data);
    }

    public function test_fail_validation_type_updateDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 120,
            'url' => 'https://google.com'
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->put('/ppid/menu-beranda/2', $data)
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Data menu gagal diupdate',
                'errors' => [
                    'judul_menu' => [
                        'The judul menu field must be a string.'
                    ]
                ]
            ]);
    }

    public function test_fail_validation_missingField_updateDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $data = [
            'judul_menu' => 'Menu modified',
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->put('/ppid/menu-beranda/2', $data)
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Data menu gagal diupdate',
                'errors' => [
                    'url' => [
                        'The url field is required.'
                    ]
                ]
            ]);
    }

    public function test_fail_id_updateDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->put('/ppid/menu-beranda/999', [])
            ->assertStatus(404)
            ->assertJson([
                'status' => 404,
                'message' => 'Menu tidak ditemukan'
            ]);
    }

    public function test_deleteDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->delete('/ppid/menu-beranda/6')
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data menu berhasil dihapus'
            ]);
    }

    public function test_fail_id_deleteDynamicMenu(){
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->delete('/ppid/menu-beranda/999')
            ->assertStatus(404)
            ->assertJson([
                'status' => 404,
                'message' => 'Menu tidak ditemukan'
            ]);
    }

}

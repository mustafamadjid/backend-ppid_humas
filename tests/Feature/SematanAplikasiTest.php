<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use App\Models\SematanAplikasi;

class SematanAplikasiTest extends TestCase
{

    public function userToken()
    {
        $user = User::factory()->create();
        $token = $user->createToken('admin')->plainTextToken;
        return $token;
    }

    public function test_success_getSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
            ->get('/ppid/sematan-aplikasi')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }

    public function test_fail_unauthenticated_getSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ')
            ->get('/ppid/sematan-aplikasi')
            ->assertStatus(500);
    }

    public function test_success_createSematanAplikasi()
    {
        $data = [
            'judul_sematan' => 'Judul Aplikasi',
            'url_sematan' => 'https://example.com',
            'icon' => 'icon-example'
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
            ->post('/ppid/sematan-aplikasi', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }

    public function test_fail_data_type_createSematanAplikasi()
    {
        $data = [
            'judul_sematan' => 123,
            'url_sematan' => 456,
            'icon' => 789
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('/ppid/sematan-aplikasi', $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function test_fail_unauthenticated_createSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ')
            ->post('/ppid/sematan-aplikasi')
            ->assertStatus(500);
    }

    public function test_success_updateSematanAplikasi()
    {
        $sematan = SematanAplikasi::factory()->create();

        $data = [
            'judul_sematan' => 'Judul Update',
            'url_sematan' => 'https://update.com',
            'icon' => 'icon-update'
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/sematan-aplikasi/' . $sematan->id_sematan, $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }

    public function test_fail_unauthenticated_updateSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ')
            ->put('/ppid/sematan-aplikasi/1')
            ->assertStatus(500);
    }

    public function test_fail_data_type_updateSematanAplikasi()
    {
        $sematan = SematanAplikasi::factory()->create();

        $data = [
            'judul_sematan' => 123,
            'url_sematan' => 456,
            'icon' => 789
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/sematan-aplikasi/' . $sematan->id_sematan, $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function test_fail_modelNotFound_updateSematanAplikasi()
    {
        $data = [
            'judul_sematan' => 'Judul Update',
            'url_sematan' => 'https://update.com',
            'icon' => 'icon-update'
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/sematan-aplikasi/9999', $data)
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }

    public function test_success_deleteSematanAplikasi()
    {
        $sematan = SematanAplikasi::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
            ->delete('/ppid/sematan-aplikasi/' . $sematan->id_sematan)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }

    public function test_fail_unauthenticated_deleteSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ')
            ->delete('/ppid/sematan-aplikasi/1')
            ->assertStatus(500);
    }

    public function test_fail_modelNotFound_deleteSematanAplikasi()
    {
        $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
            ->delete('/ppid/sematan-aplikasi/9999')
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }

}

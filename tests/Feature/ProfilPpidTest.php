<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProfilPpid;


class ProfilPpidTest extends TestCase
{
  

        public function userToken()
        {
            $user = User::factory()->create();
            $token = $user->createToken('admin')->plainTextToken;
            return $token;
        }

        public function test_success_getProfilPpid()
        {

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->get('/ppid/profil-ppid')
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_unauthenticated_getProfilPpid()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->get('/ppid/profil-ppid')
                ->assertStatus(500);
        }

        public function test_success_createProfilPpid()
        {
            $data = [
                'deskripsi_profil' => 'Deskripsi profil',
                'visi_ppid' => 'Visi PPID',
                'misi_ppid' => 'Misi PPID',
                'tugas_ppid' => 'Tugas PPID',
                'fungsi_ppid' => 'Fungsi PPID',
            ];

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->post('/ppid/profil-ppid', $data)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_data_type_createProfilPpid()
        {
            $data = [
                'deskripsi_profil' => 123,
                'visi_ppid' => 456,
                'misi_ppid' => 789,
                'tugas_ppid' => 1011,
                'fungsi_ppid' => 1213,
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->post('/ppid/profil-ppid', $data)
                ->assertStatus(422)
                ->assertJsonStructure([
                    'message',
                    'errors'
                ]);
        }

        public function test_fail_unauthenticated_createProfilPpid()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->post('/ppid/profil-ppid')
                ->assertStatus(500);
        }

        public function test_success_updateProfilPpid()
        {
            $profil = ProfilPpid::factory()->create();

            $data = [
                'deskripsi_profil' => 'Deskripsi update',
                'visi_ppid' => 'Visi update',
                'misi_ppid' => 'Misi update',
                'tugas_ppid' => 'Tugas update',
                'fungsi_ppid' => 'Fungsi update',
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/profil-ppid/' . $profil->id_profil, $data)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_unauthenticated_updateProfilPpid()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->put('/ppid/profil-ppid/1')
                ->assertStatus(500);
        }

        public function test_fail_data_type_updateProfilPpid()
        {
            $profil = ProfilPpid::factory()->create();

            $data = [
                'deskripsi_profil' => 123,
                'visi_ppid' => 456,
                'misi_ppid' => 789,
                'tugas_ppid' => 1011,
                'fungsi_ppid' => 1213,
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/profil-ppid/' . $profil->id_profil, $data)
                ->assertStatus(422)
                ->assertJsonStructure([
                    'message',
                    'errors'
                ]);
        }

        public function test_fail_modelNotFound_updateProfilPpid()
        {
            $data = [
                'deskripsi_profil' => 'Deskripsi update',
                'visi_ppid' => 'Visi update',
                'misi_ppid' => 'Misi update',
                'tugas_ppid' => 'Tugas update',
                'fungsi_ppid' => 'Fungsi update',
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/profil-ppid/9999', $data)
                ->assertStatus(404)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }

        public function test_success_deleteProfilPpid()
        {
            $profil = ProfilPpid::factory()->create();

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->delete('/ppid/profil-ppid/' . $profil->id_profil)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }

        public function test_fail_unauthenticated_deleteProfilPpid()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->delete('/ppid/profil-ppid/1')
                ->assertStatus(500);
        }

        public function test_fail_modelNotFound_deleteProfilPpid()
        {
            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->delete('/ppid/profil-ppid/9999')
                ->assertStatus(404)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }
    }
    


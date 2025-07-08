<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\DeskripsiHalamanDokumen;
use App\Models\User;

class DeskripsiHalamanDokumenTest extends TestCase
{
        public function userToken()
        {
            $user = User::factory()->create();
            $token = $user->createToken('admin')->plainTextToken;
            return $token;
        }

        public function test_success_getDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->get('ppid/deskripsi-halaman-dokumen')
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_success_getByKategori()
        {
           DeskripsiHalamanDokumen::factory()->create();

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->get('deskripsi-halaman-dokumen/informasi publik')
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_modelNotFound_getByKategori()
        {
            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->get('deskripsi-halaman-dokumen/pasaaasd')
                ->assertStatus(404)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }

        public function test_fail_unauthenticated_getDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->get('/ppid/deskripsi-halaman-dokumen')
                ->assertStatus(500);
        }

        public function test_success_createDeskripsiHalamanDokumen()
        {
            $data = [
                'deskripsi' => 'Deskripsi dokumen',
                'kategori_dokumen' => 'Kategori A'
            ];

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->post('/deskripsi-halaman-dokumen', $data)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_data_type_createDeskripsiHalamanDokumen()
        {
            $data = [
                'deskripsi' => 123,
                'kategori_dokumen' => 456
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->post('/ppid/deskripsi-halaman-dokumen', $data)
                ->assertStatus(422)
                ->assertJsonStructure([
                    'message',
                    'errors'
                ]);
        }

        public function test_fail_unauthenticated_createDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->post('/ppid/deskripsi-halaman-dokumen')
                ->assertStatus(500);
        }

        public function test_success_updateDeskripsiHalamanDokumen()
        {
            $deskripsi = DeskripsiHalamanDokumen::factory()->create();

            $data = [
                'deskripsi' => 'Deskripsi update',
                'kategori_dokumen' => 'Kategori B'
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/deskripsi-halaman-dokumen/' . $deskripsi->id_deskripsi, $data)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data'
                ]);
        }

        public function test_fail_unauthenticated_updateDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->put('/ppid/deskripsi-halaman-dokumen/1')
                ->assertStatus(500);
        }

        public function test_fail_data_type_updateDeskripsiHalamanDokumen()
        {
            $deskripsi = DeskripsiHalamanDokumen::factory()->create();

            $data = [
                'deskripsi' => 123,
                'kategori_dokumen' => 456
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/deskripsi-halaman-dokumen/' . $deskripsi->id_deskripsi, $data)
                ->assertStatus(422)
                ->assertJsonStructure([
                    'message',
                    'errors'
                ]);
        }

        public function test_fail_modelNotFound_updateDeskripsiHalamanDokumen()
        {
            $data = [
                'deskripsi' => 'Deskripsi update',
                'kategori_dokumen' => 'Kategori B'
            ];

            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->userToken(),
                'Accept' => 'application/json',
            ])->put('/ppid/deskripsi-halaman-dokumen/9999', $data)
                ->assertStatus(404)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }

        public function test_success_deleteDeskripsiHalamanDokumen()
        {
            $deskripsi = DeskripsiHalamanDokumen::factory()->create();

            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->delete('/ppid/deskripsi-halaman-dokumen/' . $deskripsi->id_deskripsi)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }

        public function test_fail_unauthenticated_deleteDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ')
                ->delete('/ppid/deskripsi-halaman-dokumen/1')
                ->assertStatus(500);
        }

        public function test_fail_modelNotFound_deleteDeskripsiHalamanDokumen()
        {
            $this->withHeader('Authorization', 'Bearer ' . $this->userToken())
                ->delete('/ppid/deskripsi-halaman-dokumen/9999')
                ->assertStatus(404)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
        }
    }




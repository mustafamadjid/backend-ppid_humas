<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\FormPengaduanInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FormPengaduanServiceTest extends TestCase
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

    public function test_getFormPengaduan(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/pengaduan')
        -> assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_getFormPengaduan(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/pengaduan')
        -> assertStatus(500);
    }

    public function test_createFormPengaduan(){
        $data = [
            'nama_pelapor' => 'Agus Santoso',
            'no_ktp_pelapor' => '3276012301123456',
            'email_pelapor' => 'agus.santoso@example.com',
            'no_telp_pelapor' => '081234567890',
            'nama_terlapor' => 'Budi Hartono',
            'jabatan_terlapor' => 'Manajer Operasional',
            'deskripsi_penyalahgunaan' => 'Terdapat penyalahgunaan wewenang dalam proses pengadaan barang.'
        ];

        $file = UploadedFile::fake()->image('image.jpg');

        $completeData = array_merge($data, ['file_bukti' => $file]);

        $this->post('/ppid/pengaduan', $completeData)
        -> assertStatus(200)
        ->assertJson([
            'status' => 200,
            'message' => 'Data pengaduan berhasil disimpan',
            'data' => [
                'nama_pelapor' => 'Agus Santoso',
                'no_ktp_pelapor' => '3276012301123456',
                'email_pelapor' => 'agus.santoso@example.com',
                'no_telp_pelapor' => '081234567890',
                'nama_terlapor' => 'Budi Hartono',
                'jabatan_terlapor' => 'Manajer Operasional',
                'deskripsi_penyalahgunaan' => 'Terdapat penyalahgunaan wewenang dalam proses pengadaan barang.',
                'path_file_bukti' => 'bukti_pengaduan/image.jpg'
            ]
            ]);
    
    }
}

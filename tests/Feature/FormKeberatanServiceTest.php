<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormKeberatanServiceTest extends TestCase
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

    public function test_sucess_getAllForm(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/keberatan')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

   public function test_success_createForm(){
    // Fake the storage
    Storage::fake('public');

    // Fake data
    $data = [
        'nama_pemohon' => 'Budi Santoso',
        'no_ktp_pemohon' => '3276012301123456',
        'email_pemohon' => 'budi@mail.com',
        'no_telp_pemohon' => '081234567890',
        'pekerjaan_pemohon' => 'Guru',
        'tujuan_pengajuan' => 'Permohonan Data',
        'alasan_pengajuan' => 'Keperluan penelitian',
        'file_bukti' => UploadedFile::fake()->create('file_bukti.pdf', 200, 'application/pdf'),
    ];
    $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('/formulir/keberatan', $data)
    ->assertStatus(200)
    ->assertJsonStructure([
        'status',
        'message',
        'data'
    ]);
   }

   public function test_success_deleteForm(){
    $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/keberatan/4')
    ->assertStatus(200)
    ->assertJsonStructure([
        'status',
        'message'
    ]);

    $this->assertDatabaseMissing('data_form_pengajuan_keberatan', ['id_pemohon' => 4]);
   }

   public function test_fail_deleteForm(){
    $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/keberatan/999')
    ->assertStatus(404)
    ->assertJsonStructure([
        'status',
        'message'
    ]);
   }

}

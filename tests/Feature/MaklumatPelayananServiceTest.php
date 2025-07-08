<?php

namespace Tests\Feature;

use App\Models\MaklumatPelayanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaklumatPelayananServiceTest extends TestCase
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

    public function test_success_getMaklumat()
    {
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('ppid/maklumat-pelayanan')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_unauthenticated_getMaklumat()
    {
        $this->get('ppid/dokumen-publik')
        ->assertStatus(500);
    }
    public function test_success_createMaklumat()
    {
        $data = [
            'deskripsi' => "Maklumat 1"
        ];

        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('ppid/maklumat-pelayanan',$data)
        ->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);

    }

    public function test_fail_validation_data_type_createMaklumat()
    {
        $data = [
            'deskripsi' => 122
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('ppid/maklumat-pelayanan',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_validation_sizes_tring_createMaklumat()
    {
        $data = [
            'deskripsi' => str_repeat("Desc",260)
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('ppid/maklumat-pelayanan',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_success_updateMaklumat()
    {
        $maklumat = MaklumatPelayanan::factory()->create();

        $data = [
            'deskripsi' => 'fitur 1',
            'is_active' => false
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('ppid/maklumat-pelayanan/'. $maklumat->id_maklumat,$data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
    public function test_fail_data_not_found_updateMaklumat()
    {
        $data = [
            'deskripsi' => 'fitur 1',
            'is_active' => false
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('ppid/maklumat-pelayanan/999',$data)
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }
    public function test_fail_validation_data_type_updateMaklumat()
    {
        $data = [
            'deskripsi' => 'fitur 1',
            'is_active' => "boolean"
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('ppid/maklumat-pelayanan/999',$data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
    public function test_fail_validation_size_string_updateMaklumat()
    {
        $maklumat = MaklumatPelayanan::factory()->create();

        $data = [
            'deskripsi' => str_repeat("Desc",256),
            'is_active' => false
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('ppid/maklumat-pelayanan/'. $maklumat->id_maklumat,$data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
    public function test_success_deleteMaklumat()
    {
        $maklumat = MaklumatPelayanan::factory()->create();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->delete('ppid/maklumat-pelayanan/'. $maklumat->id_maklumat)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_fail_data_not_found_deleteMaklumat()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->delete('ppid/maklumat-pelayanan/99999')
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }
    

    

    
}

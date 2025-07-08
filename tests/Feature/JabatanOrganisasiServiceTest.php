<?php

namespace Tests\Feature;

use App\Models\JabatanOrganisasi;
use App\Models\User;
use Tests\TestCase;

class JabatanOrganisasiServiceTest extends TestCase
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

    public function test_success_getJabatanOrganisasi(){
        
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/jabatan-organisasi')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_unauthenticated_getJabatanOrganisasi(){
        $this->withHeader('Authorization', 'Bearer ')->get('/ppid/jabatan-organisasi')
        ->assertStatus(500);
    }

    public function test_success_createJabatanOrganisasi(){
        $data = [
            'jabatan' => "Ketua",
            
        ];

        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('/ppid/jabatan-organisasi',$data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_data_type_createJabatanOrganisasi(){
        $data = [
            'jabatan' => 122,
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('/ppid/jabatan-organisasi',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_size_string_createJabatanOrganisasi(){
        $data = [
            'jabatan' => str_repeat("Desc",256),
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('/ppid/jabatan-organisasi',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_unauthenticated_createJabatanOrganisasi(){
        $this->withHeader('Authorization', 'Bearer ')->post('/ppid/jabatan-organisasi')
        ->assertStatus(500);
    }

    public function test_success_updateJabatanOrganisasi(){
        $jabatanOrganisasi = JabatanOrganisasi::factory()->create();

        $data = [
            'jabatan' => "Ketua humas",
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/jabatan-organisasi/'. $jabatanOrganisasi->id_jabatan,$data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_unauthenticated_updateJabatanOrganisasi(){
        $this->withHeader('Authorization', 'Bearer ')->put('/ppid/jabatan-organisasi/1')
        ->assertStatus(500);
    }

    public function test_fail_data_type_updateJabatanOrganisasi(){
        $jabatanOrganisasi = JabatanOrganisasi::factory()->create();

        $data = [
            'jabatan' => 122,
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/jabatan-organisasi/'. $jabatanOrganisasi->id_jabatan,$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_size_string_updateJabatanOrganisasi(){
        $jabatanOrganisasi = JabatanOrganisasi::factory()->create();

        $data = [
            'jabatan' => str_repeat("Desc",256),
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/jabatan-organisasi/'. $jabatanOrganisasi->id_jabatan,$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_modelNotFound_updateJabatanOrganisasi(){
        $data = [
            'jabatan' => "Ketua humas",
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/jabatan-organisasi/100',$data)
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_success_deleteJabatanOrganisasi(){
        $jabatanOrganisasi = JabatanOrganisasi::factory()->create();
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/jabatan-organisasi/'. $jabatanOrganisasi->id_jabatan)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_fail_unauthenticated_deleteJabatanOrganisasi(){
        $this->withHeader('Authorization', 'Bearer ')->delete('/ppid/jabatan-organisasi/1')
        ->assertStatus(500);
    }

    public function test_fail_modelNotFound_deleteJabatanOrganisasi(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/jabatan-organisasi/100')
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }


}

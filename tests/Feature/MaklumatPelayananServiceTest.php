<?php

namespace Tests\Feature;

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
    {}

    public function test_fail_validation_sizes_tring_createMaklumat()
    {}

    public function test_success_updateMaklumat()
    {}
    public function test_fail_data_not_found_updateMaklumat()
    {}
    public function test_fail_validation_data_type_updateMaklumat()
    {}
    public function test_fail_validation_size_string_updateMaklumat()
    {}
    public function test_success_deleteMaklumat()
    {}

    public function test_fail_data_not_found_deleteMaklumat()
    {}
    

    

    
}

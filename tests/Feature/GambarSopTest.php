<?php

namespace Tests\Feature;

use App\Models\GambarSop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GambarSopTest extends TestCase
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

    public function test_success_getGambarSop(){
        
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/gambar-sop')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_unauthenticated_getGambarSop(){
        $this->withHeader('Authorization', 'Bearer ')->get('/ppid/gambar-sop')
        ->assertStatus(500);
    }

    public function test_success_createGambarSop(){
        $data = [
            'file_gambar' => UploadedFile::fake()->image('test.png'),
            'order' => 1
        ];

        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('/ppid/gambar-sop',$data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_data_type_createGambarSop(){
        $data = [
            'file_gambar' => 123,
            'order' => "asad"
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('/ppid/gambar-sop',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_file_type_createGambarSop(){
        $data = [
            'file_gambar' => UploadedFile::fake()->create('test.txt'),
            'order' => 1
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->post('/ppid/gambar-sop',$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_unauthenticated_createGambarSop(){
        $this->withHeader('Authorization', 'Bearer ')->post('/ppid/gambar-sop')
        ->assertStatus(500);
    }

    public function test_success_updateGambarSop(){
        $GambarSop = GambarSop::factory()->create();

        $data = [
            'file_gambar' => UploadedFile::fake()->image('test.png'),
            'order' => 1,
            'is_active' => false
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/gambar-sop/'. $GambarSop->id_gambar,$data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_unauthenticated_updateGambarSop(){
        $this->withHeader('Authorization', 'Bearer ')->put('/ppid/gambar-sop/1')
        ->assertStatus(500);
    }

    public function test_fail_data_type_updateGambarSop(){
        $GambarSop = GambarSop::factory()->create();

        $data = [
            'file_gambar' => 123,
            'order' => "asad"
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/gambar-sop/'. $GambarSop->id_gambar,$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_file_type_updateGambarSop(){
        $GambarSop = GambarSop::factory()->create();

        $data = [
            'file_gambar' => UploadedFile::fake()->create('test.txt'),
            'order' => 1
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/gambar-sop/'. $GambarSop->id_gambar,$data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_modelNotFound_updateGambarSop(){
        $data = [
            'jabatan' => "Ketua humas",
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken(),
            'Accept' => 'application/json',
        ])->put('/ppid/gambar-sop/100',$data)
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_success_deleteGambarSop(){
        $GambarSop = GambarSop::factory()->create();
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/gambar-sop/'. $GambarSop->id_gambar)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_fail_unauthenticated_deleteGambarSop(){
        $this->withHeader('Authorization', 'Bearer ')->delete('/ppid/gambar-sop/1')
        ->assertStatus(500);
    }

    public function test_fail_modelNotFound_deleteGambarSop(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/gambar-sop/100')
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

}

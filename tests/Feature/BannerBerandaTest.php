<?php

namespace Tests\Feature;

use App\Models\BannerBeranda;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BannerBerandaTest extends TestCase
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

    public function test_success_getBanner()
{
    $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('ppid/banner-beranda')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
}

public function test_fail_unauthenticated_getBanner()
{
    $this->get('ppid/banner-beranda')
        ->assertStatus(500);
}

public function test_success_createBanner()
{
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => 1
    ];

    $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('ppid/banner-beranda', $data)
        ->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
}

public function test_fail_validation_data_type_createBanner()
{
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => "100"
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->post('ppid/banner-beranda', $data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
}

public function test_fail_validation_file_type_createBanner()
{
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.mov'),
        'order' => 2
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->post('ppid/banner-beranda', $data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
}
public function test_fail_validation_size_int_createBanner()
{
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => 10
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->post('ppid/banner-beranda', $data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
}

public function test_success_updateBanner()
{
    $banner = BannerBeranda::factory()->create();

    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => 2,
        'is_active' => 0
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/banner-beranda/' . $banner->id_gambar, $data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
}

public function test_fail_data_not_found_updateBanner()
{
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => 2,
        'is_active' => 0
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/banner-beranda/9999',$data)
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message',
        ]);
}

public function test_fail_validation_data_type_updateBanner()
{
    $banner = BannerBeranda::factory()->create();
    $data = [
        'file_gambar' => UploadedFile::fake()->create('image.png'),
        'order' => 2,
        'is_active' => '1000'
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/banner-beranda/'. $banner->id_gambar, $data)
        ->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
}



public function test_success_deleteBanner()
{
    $banner = BannerBeranda::factory()->create();

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->delete('ppid/banner-beranda/' . $banner->id_gambar)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
}

public function test_fail_data_not_found_deleteBanner()
{
    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->delete('ppid/banner-beranda/99999')
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
}

    
}

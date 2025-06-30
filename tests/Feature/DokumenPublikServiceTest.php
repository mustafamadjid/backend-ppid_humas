<?php

namespace Tests\Feature;

use App\Models\DokumenPublik;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DokumenPublikServiceTest extends TestCase
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

    public function test_success_createDokumenPublik(){
        $data = 
        [
            'nama_dokumen' => 'dokumen layanan informasi',
            'kategori_dokumen' => 'informasi publik',
            'tahun_dokumen' => 2025,
            'file_dokumen' => UploadedFile::fake()->create('dokumen.pdf')
        ];

        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->post('ppid/dokumen-publik', $data)
        -> assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_fail_size_createDokumenPublik(){
        $data = 
        [
            'nama_dokumen' => 'dokumen layanan informasi',
            'kategori_dokumen' => 'informasi publik',
            'tahun_dokumen' => 2025,
            'file_dokumen' => UploadedFile::fake()->create('dokumen.pdf',1024*25)
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken(),
            'Accept' => 'application/json'
        ])->post('ppid/dokumen-publik', $data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_datatype_createDokumenPublik(){
        $data = 
        [
            'nama_dokumen' => 'dokumen layanan informasi',
            'kategori_dokumen' => 900,
            'tahun_dokumen' => 2025,
            'file_dokumen' => UploadedFile::fake()->create('dokumen.pdf')
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken(),
            'Accept' => 'application/json'
        ])->post('ppid/dokumen-publik', $data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_fail_doctype_createDokumenPublik(){
        $data = 
        [
            'nama_dokumen' => 'dokumen layanan informasi',
            'kategori_dokumen' => 900,
            'tahun_dokumen' => 2025,
            'file_dokumen' => UploadedFile::fake()->create('dokumen.mov')
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken(),
            'Accept' => 'application/json'
        ])->post('ppid/dokumen-publik', $data)
        -> assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_success_updateDokumenPublik()
{
    $dokumen = DokumenPublik::factory()->create();

    $data = [
        'nama_dokumen' => 'dokumen layanan informasi revisi',
        'kategori_dokumen' => 'informasi publik',
        'tahun_dokumen' => 2026,
        'file_dokumen' => UploadedFile::fake()->create('dokumen_update.pdf'),
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/dokumen-publik/' . $dokumen->id, $data)
      ->assertStatus(200)
      ->assertJsonStructure([
          'status',
          'message',
          'data',
      ]);
}

public function test_fail_size_updateDokumenPublik()
{
    $dokumen = DokumenPublik::factory()->create();

    $data = [
        'nama_dokumen' => 'dokumen layanan informasi revisi',
        'kategori_dokumen' => 'informasi publik',
        'tahun_dokumen' => 2026,
        'file_dokumen' => UploadedFile::fake()->create('dokumen_update.pdf', 1024 * 25), // 25MB
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/dokumen-publik/' . $dokumen->id, $data)
      ->assertStatus(422)
      ->assertJsonStructure([
          'message',
          'errors',
      ]);
}

public function test_fail_datatype_updateDokumenPublik()
{
    $dokumen = DokumenPublik::factory()->create();

    $data = [
        'nama_dokumen' => 'dokumen layanan informasi revisi',
        'kategori_dokumen' => 900,
        'tahun_dokumen' => 2026,
        'file_dokumen' => UploadedFile::fake()->create('dokumen_update.pdf'),
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/dokumen-publik/' . $dokumen->id, $data)
      ->assertStatus(422)
      ->assertJsonStructure([
          'message',
          'errors',
      ]);
}

public function test_fail_doctype_updateDokumenPublik()
{
    $dokumen = DokumenPublik::factory()->create();

    $data = [
        'nama_dokumen' => 'dokumen layanan informasi revisi',
        'kategori_dokumen' => 'informasi publik',
        'tahun_dokumen' => 2026,
        'file_dokumen' => UploadedFile::fake()->create('dokumen.mov'), // file bukan pdf
    ];

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->userToken(),
        'Accept' => 'application/json',
    ])->put('ppid/dokumen-publik/' . $dokumen->id, $data)
      ->assertStatus(422)
      ->assertJsonStructure([
          'message',
          'errors',
      ]);
}
}

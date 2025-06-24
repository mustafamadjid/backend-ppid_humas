<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormPermohonanInformasiTest extends TestCase
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

    public function test_success_getAllForm(){
        $this->withHeader('Authorization', 'Bearer '.$this->userToken())->get('/ppid/permohonan-informasi')
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_success_createForm(){
        $data = [
                "nama_pemohon" => "Budi Santoso",
                "no_ktp_pemohon" => "3276012309876543",
                "alamat_pemohon" => "Jl. Merdeka No. 10, Jakarta",
                "no_telp_pemohon" => "081234567890",
                "email_pemohon" => "budi.santoso@example.com",
                "kebutuhan_informasi_pemohon" => "Data statistik pendidikan tahun 2024.",
                "alasan_permintaan" => "Digunakan untuk penelitian skripsi.",
                "nama_pengguna" => "Andi Wijaya",
                "no_ktp_pengguna" => "3201021409871234",
                "alamat_pengguna" => "Jl. Sudirman No. 22, Bandung",
                "no_telp_pengguna" => "081987654321",
                "email_pengguna" => "andi.wijaya@example.com",
                "kebutuhan_informasi_pengguna" => "Laporan keuangan desa tahun 2023.",
                "alasan_penggunaan" => "Sebagai bahan laporan tugas akhir.",
                "cara_perolehan_informasi" => "Melalui permohonan online di website resmi.",
                "format_informasi" => "Dokumen PDF",
                "cara_pengiriman_informasi" => "Dikirim melalui email"
        ];

        $this->post('/formulir/permohonan-informasi', $data)
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    } 

    public function test_fail_validation_type_createForm(){
        $data = [
                "nama_pemohon" => 22222,
                "no_ktp_pemohon" => "3276012309876543",
                "alamat_pemohon" => "Jl. Merdeka No. 10, Jakarta",
                "no_telp_pemohon" => "081234567890",
                "email_pemohon" => "budi.santoso@example.com",
                "kebutuhan_informasi_pemohon" => "Data statistik pendidikan tahun 2024.",
                "alasan_permintaan" => "Digunakan untuk penelitian skripsi.",
                "nama_pengguna" => "Andi Wijaya",
                "no_ktp_pengguna" => "3201021409871234",
                "alamat_pengguna" => "Jl. Sudirman No. 22, Bandung",
                "no_telp_pengguna" => "081987654321",
                "email_pengguna" => "andi.wijaya@example.com",
                "kebutuhan_informasi_pengguna" => "Laporan keuangan desa tahun 2023.",
                "alasan_penggunaan" => "Sebagai bahan laporan tugas akhir.",
                "cara_perolehan_informasi" => "Melalui permohonan online di website resmi.",
                "format_informasi" => "Dokumen PDF",
                "cara_pengiriman_informasi" => "Dikirim melalui email"
        ];

        $this->post('/formulir/permohonan-informasi', $data)
        ->assertStatus(400)
        ->assertJsonStructure([
            'status',
            'message',
            'errors'
        ]);
    }
    
    public function test_fail_validation_missing_field_createForm(){
        $data = [
            "no_ktp_pemohon" => "3276012309876543",
            "alamat_pemohon" => "Jl. Merdeka No. 10, Jakarta",
            "no_telp_pemohon" => "081234567890",
            "email_pemohon" => "budi.santoso@example.com",
            "kebutuhan_informasi_pemohon" => "Data statistik pendidikan tahun 2024.",
            "alasan_permintaan" => "Digunakan untuk penelitian skripsi.",
            "nama_pengguna" => "Andi Wijaya",
            "no_ktp_pengguna" => "3201021409871234",
            "alamat_pengguna" => "Jl. Sudirman No. 22, Bandung",
            "no_telp_pengguna" => "081987654321",
            "email_pengguna" => "andi.wijaya@example.com",
            "kebutuhan_informasi_pengguna" => "Laporan keuangan desa tahun 2023.",
            "alasan_penggunaan" => "Sebagai bahan laporan tugas akhir.",
            "cara_perolehan_informasi" => "Melalui permohonan online di website resmi.",
            "format_informasi" => "Dokumen PDF",
            "cara_pengiriman_informasi" => "Dikirim melalui email"
    ];

    $this->post('/formulir/permohonan-informasi', $data)
    ->assertStatus(400)
    ->assertJsonStructure([
        'status',
        'message',
        'errors'
    ]);
    }

    public function test_fail_validation_lengthException_createForm(){
        $data = [
                 "nama_pemohon" => "Budi Santoso",
                "no_ktp_pemohon" => "3276012309876543",
                "alamat_pemohon" => "Jl. Merdeka No. 10, Jakarta",
                "no_telp_pemohon" => "0812345678909595959959",
                "email_pemohon" => "budi.santoso@example.com",
                "kebutuhan_informasi_pemohon" => "Data statistik pendidikan tahun 2024.",
                "alasan_permintaan" => "Digunakan untuk penelitian skripsi.",
                "nama_pengguna" => "Andi Wijaya",
                "no_ktp_pengguna" => "320102140987123498049084904390",
                "alamat_pengguna" => "Jl. Sudirman No. 22, Bandung",
                "no_telp_pengguna" => "081987654321",
                "email_pengguna" => "andi.wijaya@example.com",
                "kebutuhan_informasi_pengguna" => "Laporan keuangan desa tahun 2023.",
                "alasan_penggunaan" => "Sebagai bahan laporan tugas akhir.",
                "cara_perolehan_informasi" => "Melalui permohonan online di website resmi.",
                "format_informasi" => "Dokumen PDF",
                "cara_pengiriman_informasi" => "Dikirim melalui email"
        ];

        $this->post('/formulir/permohonan-informasi', $data)
        ->assertStatus(400)
        ->assertJsonStructure([
            'status',
            'message',
            'errors'
        ]);
     }

     public function test_success_deleteForm(){
      $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/permohonan-informasi/3')
      ->assertStatus(200)
      ->assertJsonStructure([
          'status',
          'message'
      ]);
     }

     public function test_fail_modelNotFound_deleteForm(){
      $this->withHeader('Authorization', 'Bearer '.$this->userToken())->delete('/ppid/permohonan-informasi/100')
      ->assertStatus(404)
      ->assertJsonStructure([
          'status',
          'message'
      ]);
     }
}

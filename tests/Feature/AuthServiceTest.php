<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthServiceTest extends TestCase
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

    public function test_login_success_username_authService()
    {
        $this->post('/auth/login',[
            'username' => 'admin',
            'password' => 'admin123'
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'=>['token']
        ]);
    }

    

    public function test_login_success_email_authService()
    {
        $this->post('/auth/login',[
            'email' => 'lkhs@example',
            'password' => 'suanrman'
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data'=>['token']
        ]);
    }


    public function test_login_fail_username_authService() {
        $this->post('/auth/login',[
            'username' => 'adminajax',
            'password' => 'admin123'
        ])
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message',
            'error'
        ]);
    }

    public function test_login_fail_type_username_authService() {
        $this->post('/auth/login',[
            'username' => 1,
            'password' => 'admin123'
        ])
        ->assertStatus(422)
        ->assertJsonStructure([
            'status',
            'message',
            'error'
        ]);
    }

    public function test_login_fail_type_email_authService() {
        $this->post('/auth/login',[
            'email' => 1,
            'password' => 'admin123'
        ])
        ->assertStatus(422)
        ->assertJsonStructure([
            'status',
            'message',
            'error'
        ]);
    }

    public function test_login_fail_email_authService() {
        $this->post('/auth/login',[
            'email' => 'adminajax@example',
            'password' => 'admin123'
        ])
        ->assertStatus(404)
        ->assertJsonStructure([
            'status',
            'message',
            
        ]);
    }

    public function test_login_fail_password_authService() 
    {
        $this->post('/auth/login',[
            'username' => 'admin',
            'password' => 'admin1234'
        ])
        ->assertStatus(401)
        ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_login_fail_password_minimum_authService(){
        $this->post('/auth/login',[
            'username' => 'admin',
            'password' => 'adm'
        ])
        ->assertStatus(422)
        ->assertJsonStructure([
            'status',
            'message',
            'error'
        ]);
    }

    public function test_authenticated_authService() {
       $this->withHeader('Authorization', 'Bearer '.$this->userToken())
       -> get('/ppid/user')
       ->assertStatus(200)
       ->assertJsonStructure([
           'status',
           'message',
           'data'
       ]);
    }

    public function test_unauthenticated_authService() {
        $this->get('/ppid/user')
        ->assertStatus(500);
    }
}

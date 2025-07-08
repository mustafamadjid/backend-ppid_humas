<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\authRequest;
use App\Models\User;
use App\Services\AuthServices\AuthServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }
    public function login(authRequest $request)
    {
        
        try {
            $validated = $request->validated();
        
            $auth = $this->authService->doLogin($validated['email'], $validated->validated()['password']);
                

            if(!$auth){
                return response()->json([
                    'status' => 401,
                    'message' => 'Password atau email tidak sesuai'
                ], 401);
            }else{
                return response()->json([
                    'status' => 200,
                    'message' => 'Login berhasil',
                    'data' => [
                        'token' => $auth
                    ]
                    ]);
            }        
                 
        } catch (\Throwable $e) {
           throw new HttpException(500, $e->getMessage());
        }
    }

    public function logout(Request $request){
        try {
            $logout =  $request->user()->currentAccessToken()->delete();

            if ($logout) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Logout berhasil',
                ]);
            }
            return response()->json([
                'status' => 500,
                'message' => 'Logout gagal',
            ]);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
}



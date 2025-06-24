<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function login(Request $request)
    {
        
        try {
            $validated = Validator::make($request->all(), [
                'username' => [
                    'sometimes',
                    'string',
                ],
                'email' => [
                    'sometimes',
                    'email'
                ],
                'password' => [
                    'sometimes',
                    'string',
                    'min:6',
                ],
            ]);
    
            if ($validated->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Data login tidak sesuai',
                    'error' => $validated->errors()
                ], 422);
            }

            if(empty($validated->validated()['username'])){
                if(empty($validated->validated()['email'])){
                    return response()->json([
                        'status' => 422,
                        'message' => 'Data login tidak sesuai',
                        'error' => $validated->errors()
                    ], 422);
                }else{
                    $user = User::where('email', $validated->validated()['email'])->first();

                    if($user === null){
                        return response()->json([
                            'status' => 404,
                            'message' => 'User dengan email : '.$validated->validated()['email'].' tidak ditemukan',
                        ], 404);
                    }

                    $auth = $this->authService->doLogin($user, $validated->validated()['password']);
        
                    if (!$auth) {
                        return response()->json([
                            'status' => 401,
                            'message' => 'Password salah untuk email : '.$validated->validated()['email'],
                        ], 401);
                    }
        
                    return response()->json([
                        'status' => 200,
                        'message' => 'Login berhasil',
                        'data' => [
                            'token' => $auth
                        ]
                        ]);
                     }
                 }else{
                    $user = User::where('username', $validated->validated()['username'])->first();

                    if($user === null){
                        return response()->json([
                            'status' => 404,
                            'message' => 'User dengan username : '.$validated->validated()['username'].' tidak ditemukan',
                        ], 404);
                    }

                    $auth = $this->authService->doLogin($user, $validated->validated()['password']);
        
                    if (!$auth) {
                        return response()->json([
                            'status' => 401,
                            'message' => 'Password salah untuk username : '.$validated->validated()['username'],
                        ], 401);
                    }
        
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



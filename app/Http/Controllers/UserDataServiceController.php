<?php

namespace App\Http\Controllers;

use App\Http\Requests\userDataRequest\createUserRequest;
use App\Http\Requests\userDataRequest\UpdateUserRequest;
use App\Models\User;
use App\Services\DataServiceInterface;
use App\Services\UserDataServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserDataServiceController extends Controller
{
    private DataServiceInterface $userDataService;

    public function __construct(DataServiceInterface $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    public function store (createUserRequest $request)
    {
       try {
        $user = $this->userDataService->createData($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'User baru berhasil diregistrasikan',
            'data' => [
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role
            ]
        ], 201);
       } catch (\Throwable $e) {
        throw new HttpException(500, $e->getMessage());
       }
    }

    public function index()
    {
        try {
            $data = $this->userDataService->getData();

            return response()->json([
                'status' => 200,
                'message' => 'Data semua user berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $data = $this->userDataService->updateData($id, $request->validated( ));

            if(!$data ){
                return response()->json([
                    'status' => 404,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }
    
            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil diupdate',
                'data' => $data
            ]);
        }catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            
            $data = $this->userDataService->deleteData($id);

            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil dihapus',
                'data' => $data
            ]);
        } catch (\Throwable$e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}

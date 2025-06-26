<?php

namespace App\Http\Controllers;

use App\Http\Requests\userDataRequest\UpdateUserRequest;
use App\Models\User;
use App\Services\UserDataServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserDataServiceController extends Controller
{
    private UserDataServiceInterface $userDataService;

    public function __construct(UserDataServiceInterface $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    public function index()
    {
        try {
            $data = $this->userDataService->getAllUserData();

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
            $user = User::findOrFail($id);
            $data = $this->userDataService->updateUserData($user, $request->validated( ));
    
            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil diupdate',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $this->userDataService->deleteUserData($user);

            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil dihapus',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Throwable$e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}

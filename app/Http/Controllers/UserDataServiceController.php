<?php

namespace App\Http\Controllers;

use App\Http\Requests\userDataRequest\createUserRequest;
use App\Http\Requests\userDataRequest\UpdateUserRequest;
use App\Services\DataServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserDataServiceController extends Controller
{
    private DataServiceInterface $userDataService;

    public function __construct(DataServiceInterface $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    public function store(createUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $username = "new user";
           

            $createdUser = $this->userDataService->createData($validated, $username);

            return response()->json([
                'status' => 201,
                'message' => 'User baru berhasil diregistrasikan',
                'data' => [
                    'username' => $createdUser->username,
                    'email' => $createdUser->email,
                    'role' => $createdUser->role
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
            $validated = $request->validated();
            $user = $request->user();
            $username = $user ? $user->username : null;

            $data = $this->userDataService->updateData($id, $validated, $username);

            if (!$data) {
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
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            $username = $user ? $user->username : null;

            $data = $this->userDataService->deleteData($id, $username);

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
        } catch (\Throwable $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}

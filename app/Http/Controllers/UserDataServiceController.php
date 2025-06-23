<?php

namespace App\Http\Controllers;

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
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        
    
        try {
            $user = User::findOrFail($id);

            $validated = Validator::make($request->all(), [
                'username' => [
                    'sometimes',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore($id, 'id_user'),
                ],
                'email' => [
                    'sometimes',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($id, 'id_user'),
                ],
                'role' => [
                    'sometimes',
                    'string',
                    'max:255',
                ],
            ]);
        
            if ($validated->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Data user gagal diupdate',
                    'errors' => $validated->errors()
                ], 422);
            }
            $data = $this->userDataService->updateUserData($user, $validated->validated());
    
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}

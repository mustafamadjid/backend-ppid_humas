<?php

namespace App\Http\Controllers;

use App\Services\UserRegistrationServiceInterface;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRegistrationServiceController extends Controller
{
    private UserRegistrationServiceInterface $userRegistrationService;

    public function __construct(UserRegistrationServiceInterface $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    // Register Action
    public function store (Request $request):JsonResponse
    {
       try {
        $validated = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username'),
            ],

            'password' => 'required|string|min:6',
                'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'role' => [
                'required',
                'string',
                'max:255',
            ]
        ]);
       

        if ($validated->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'User baru gagal diregistrasikan',
                'errors' => $validated->errors()
            ]);
        }

        $user = $this->userRegistrationService->registerUser($validated->validated());

        return response()->json([
            'status' => 201,
            'message' => 'User baru berhasil diregistrasikan',
            'data' => [
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role
            ]
        ], 201);
       } catch (\Exception $e) {
        throw new HttpException(500, $e->getMessage());
       }
    }
}


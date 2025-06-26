<?php

namespace App\Http\Controllers;

use App\Http\Requests\userDataRequest\createUserRequest;
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
    public function store (createUserRequest $request):JsonResponse
    {
       try {
        $user = $this->userRegistrationService->registerUser($request->validated());

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
}


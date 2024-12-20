<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;

class AuthController extends BaseController
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();    
    }

    /**
     * Login user
     *
     * @return UserResource
     */
    public function login(LoginRequest $request): UserResource
    {
        $user = $this->authService->login($request->validated());

        $data = [
            'message' => 'Logged in successfully'
        ];

        return (new UserResource($user))->additional($data);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->message('Logged out successfully')->sendResponse();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Api\BaseController;

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
     * Login
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->authService->login($request->validated());

        return $this->sendResponse($response);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     * 
     */
    public function logout(): JsonResponse
    {
        $response = $this->authService->logout();

        return $this->sendResponse($response);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\SignupRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    private UserService $userService; 

    public function __construct()
    {
        $this->userService = new UserService();    
    }

    /**
     * Get users
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $response = $this->userService->getUsers();

        return $this->sendResponse($response);
    }

    /**
     * Signup
     *
     * @return JsonResponse
     */
    public function signup(SignupRequest $request): JsonResponse
    {
        $response = $this->userService->signup($request->validated());

        return $this->sendResponse($response);
    }

    /**
     * Confirm email
     * 
     * @return JsonResponse
     */
    public function confirmEmail(): JsonResponse
    {
        $response = $this->userService->confirmEmail(
            request()->input('token')
        );

        return $this->sendResponse($response);
    }

    /**
     * Update users
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $response = $this->userService->update($request->validated());

        return $this->sendResponse($response);
    }

    /**
     * Get a user
     *
     * @param string $id
     * 
     * @return JsonResponse
     * 
     */
    public function getUser($id): JsonResponse
    {
        $result = $this->userService->getUser($id);

        return response()->json($result);
    }
}

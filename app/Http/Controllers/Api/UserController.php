<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\SignupRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    private UserService $userService; 

    public function __construct()
    {
        $this->userService = new UserService(request()->route('user_id'));    
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
     * Signup user
     *
     * @return JsonResponse
     */
    public function signup(SignupRequest $request): JsonResponse
    {
        $user = $this->userService->signup($request->validated());

        return (new UserResource($user))
            ->additional(['message' => 'Please check your inbox for the email confirmation.'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Confirm email
     * 
     * @return UserResource
     */
    public function confirmEmail(): UserResource
    {
        $user = $this->userService->confirmEmail(request()->input('token'));

        return (new UserResource($user))
            ->additional(['message' => 'Email confirmed']);
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
     * @return UserResource
     */
    public function getUser(): UserResource
    {
        $user = $this->userService->getUser();

        return (new UserResource($user));
    }
}

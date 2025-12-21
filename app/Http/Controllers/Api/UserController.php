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

    public function __construct(
        private readonly UserService $userService
    ) {}

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
        $user = $this->userService->confirmEmail(request('token'));

        return (new UserResource($user))
            ->additional(['message' => 'Email confirmed']);
    }

    /**
     * Update user
     *
     * @return UserResource
     */
    public function update(UpdateUserRequest $request): UserResource
    {
        $user = $this->userService->update(
            auth()->user(), 
            $request->validated()
        );

        return (new UserResource($user));
    }

    /**
     * Get a user
     *
     * @return UserResource
     */
    public function getUser(): UserResource
    {
        $user = $this->userService->getUser(request('uuid'));

        return (new UserResource($user));
    }
}

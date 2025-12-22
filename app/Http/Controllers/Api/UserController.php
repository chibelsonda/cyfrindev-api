<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\SignupRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends BaseController
{

    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Get users
     *
     * @return JsonResponse
     */
    public function index(): ResourceCollection
    {
        $users = $this->userService->getUsers();

        return UserResource::collection($users)
            ->additional(['success' => true]);
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
     * Verify email
     * 
     * @return UserResource
     */
    public function verifyEmail(): UserResource
    {
        $user = $this->userService->verifyEmail(request('token'));

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
     * Get user
     *
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return (new UserResource($user));
    }
}

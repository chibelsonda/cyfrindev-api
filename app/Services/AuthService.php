<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AuthService extends BaseService
{
    /**
     * Login user
     *
     * @param array $user
     * 
     * @return User
     */
    public function login($user): User
    {
        $credential = [
            'email' => $user['email'],
            'password' => $user['password']
        ];

        if (!Auth::attempt($credential)) {
            throw new AuthenticationException('Invalid username or password.');
        }

        $user = Auth::user();
        if (is_null($user->email_verified_at)) {
            throw new UnprocessableEntityHttpException('Please confirm your email first.');
        }

        $user['auth_token'] = $user->createToken('auth_token')->plainTextToken;

        return $user;
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }
}

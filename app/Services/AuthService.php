<?php

namespace App\Services;

use App\Exceptions\AppRuntimeException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Login user
     *
     * @param array $credentials
     * 
     * @return User
     */
    public function login(array $credentials): User
    {
        if (!Auth::attempt($credentials)) {
            throw new AppRuntimeException('Invalid username or password.');
        }

        $user = Auth::user();
        if (is_null($user->email_verified_at)) {
            throw new AppRuntimeException('Please confirm your email first.');
        }

        return $user;
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::user()?->currentAccessToken()?->delete();
    }
}

<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService
{
    /**
     * Login
     *
     * @param array $user
     * 
     * @return array
     */
    public function login($user): array
    {
        try {
            $credential = [
                "email" => $user['email'],
                "password" => $user['password']
            ];

            if (!Auth::attempt($credential)) {
                return $this->setUnauthorizedResponse("Invalid username or password");
            }

            $user = Auth::user();
            $user = [
                'id' => $user->uuid,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'auth_token' => $user->createToken('auth_token')->plainTextToken
            ];

            return $this->setResponse(
                message:"Logged in successfully", 
                data: ["user" => $user]
            );

        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Logout user
     *
     * @return array
     */
    public function logout(): array
    {
        try { 
            Auth::user()->currentAccessToken()->delete();

            return $this->setResponse("Successfully logged out");

        } catch(Exception $e) {
            return $this->handleError($e);
        }
    }
}

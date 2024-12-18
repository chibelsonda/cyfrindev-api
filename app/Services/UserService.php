<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Mail\Email;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Str;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserService extends BaseService
{
    /**
     * Get users
     *
     * @return array
     */
    public function getUsers(): array
    {
        try {
            $users = User::all();

            return $this->setResponse(data: ['users' => $users]);

        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Signup
     *
     * @param array $user
     * 
     * @return array
     */
    public function signup($user): array
    {
        try {

            $user = [
                "email" => $user['email'],
                "password" => bcrypt($user['password'])
            ];

            User::create($user);

            $email = [
                "subject" => "Email Confirmation",
                "to" => $user['email'],
                "view" => "emails.confirmation",
                "content" => [
                    "token" => Crypt::encrypt($user)
                ]
            ];

            dispatch(new SendEmailJob(new Email($email)));
            
            return $this->setResponse(
                message: "Please check your inbox for email confirmation."
            );

        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

     /**
     * Confirm email
     *
     * @param string $token
     * 
     * @return array
     */
    public function confirmEmail($token): array
    {
        try {
            if (!$token) {
                return $this->setUnprocessableResponse("Token is required.");
            }

            $credential = Crypt::decrypt($token);

            if (!isset($credential['email']) || !isset($credential['password'])) {
                return $this->setUnprocessableResponse("Invalid token");
            }

            $user = User::where('email', $credential['email'])
                ->where('password', $credential['password'])
                ->first();

            if (!$user) {
                return $this->setUnprocessableResponse("User does not exist.");
            }

            if (!is_null($user->email_verified_at)) {
                return $this->setUnprocessableResponse("Email is already confirmed.");
            }

            $user->email_verified_at = Carbon::now();
            $user->save();

            $user = [
                'name' => $user->name,
                'email' => $user->email,
                'auth_token' => $user->createToken('auth_token')->plainTextToken
            ];

            return $this->setResponse(
                message: "Email has been confirmed.",
                data: ["user" => $user]
            );
        } catch (DecryptException $e) {
            return $this->setUnprocessableResponse($e->getMessage());
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Update a user
     *
     * @param array $user
     * 
     * @return array
     */
    public function update($user): array
    {
        try {
            
            $userId = auth()->user()->id;

            Log::error(json_encode($user));
            
            if (isset($user['image'])) {
                $path = '/images/profile/';
                $imageName = sha1($userId). "." . $user['image']->getClientOriginalExtension();
                $user['image']->move(public_path($path), $imageName);

                $user['image'] = $path . $imageName;
            } 

            User::where('id', $userId)->update($user);

            return $this->setResponse("User has been updated.");
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Get user
     *
     * @param string $id
     * 
     * @return array
     * 
     */
    public function getUser($id): array
    {
        try {
            $user = User::where('uuid', $id)->first();

            return $this->setResponse(
                data: ["user" => $user]
            );
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }
}

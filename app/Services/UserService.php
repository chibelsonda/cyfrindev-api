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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService extends BaseService
{    
    /**
     * @var User
     */
    private $user;

    public function __construct(private $id)
    {
        if ($id) {
            $this->user = User::where('uuid', $id)->first();
        }
    }

    
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
     * @return User
     */
    public function signup($user): User
    {
        $user['password'] = bcrypt($user['password']);

        $user = User::create($user);

        // $email = [
        //     "subject" => "Email Confirmation",
        //     "to" => $user['email'],
        //     "view" => "emails.confirmation",
        //     "content" => [
        //         "token" => Crypt::encrypt($user)
        //     ]
        // ];
        // dispatch(new SendEmailJob(new Email($email)));

        return $user;
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
     * @return User
     */
    public function getUser(): User
    {
        if (!$this->user) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->user;
    }
}

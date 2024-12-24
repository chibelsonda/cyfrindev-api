<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\Email;
use App\Models\User;
use App\Jobs\SendEmailJob;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

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
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::all();
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
        try {
        $user['password'] = bcrypt($user['password']);

        $u = User::create($user);

        $email = [
            'subject' => 'Email Confirmation',
            'to' => $user['email'],
            'view' => 'emails.confirmation',
            'content' => [
                'token' => Crypt::encrypt($user)
            ]
        ];
        dispatch(new SendEmailJob(new Email($email)));

        return $u;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

     /**
     * Confirm email
     *
     * @param string $token
     * 
     * @return User
     */
    public function confirmEmail($token): User
    {
        if (!$token) {
            throw new UnprocessableEntityHttpException('Token is required.');
        }

        $credential = Crypt::decrypt($token);

        if (!isset($credential['email']) || !isset($credential['password'])) {
            throw new UnprocessableEntityHttpException('Invalid token');
        }

        $user = User::where('email', $credential['email'])
            ->where('password', $credential['password'])
            ->first();

        if (!$user) {
            throw new UnprocessableEntityHttpException('User does not exist.');
        }

        if (!is_null($user->email_verified_at)) {
            throw new UnprocessableEntityHttpException('Email is already confirmed.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        $user['auth_token'] = $user->createToken('auth_token')->plainTextToken;

        return $user;
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
        if (isset($user['image'])) {
            $path = '/images/profile/';
            $imageName = sha1($this->user->id). "." . $user['image']->getClientOriginalExtension();
            $user['image']->move(public_path($path), $imageName);

            $user['image'] = $path . $imageName;
        } 

        User::where('id', $this->user->id)->update($user);

        return User::find($this->user->id);
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

<?php

namespace App\Services;

use App\Exceptions\AppRuntimeException;
use Exception;
use Carbon\Carbon;
use App\Mail\Email;
use App\Models\User;
use App\Jobs\SendEmailJob;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserService extends BaseService
{    
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
    public function signup(array $user): User
    {
        // implement transaction just in case encrypt fails, prevent from saving the user
        return DB::transaction(function () use ($user) {

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
        });
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

        try {
            $credential = Crypt::decrypt($token);
        }  catch (Exception $ex) {
            throw new UnprocessableEntityHttpException('Invalid token');
        }

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
     * @param User $user
     * @param array $data
     * 
     * @return User
     */
    public function update(User $user, array $data): User
    {
        if (isset($data['image'])) {
            $data['image'] = $this->storeProfileImage($user, $data['image']);
        }

        $user->update($data);

        return $user->refresh();
    }

    /**
     * Store profile image
     *
     * @param User $user
     * @param [type] $image
     * 
     * @return string
     */
    private function storeProfileImage(User $user, $image): string
    {
        return $image->storeAs(
            'images/profile',
            sha1($user->id).'.'.$image->getClientOriginalExtension(),
            'public'
        );
    }

    /**
     * Get user
     * 
     * @param string $uuid
     * 
     * @return User
     */
    public function getUser(string $uuid): User
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            throw new AppRuntimeException('User not found');
        }

        return $user;
    }
}

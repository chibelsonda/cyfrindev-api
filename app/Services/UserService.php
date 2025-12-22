<?php

namespace App\Services;

use App\Exceptions\AppRuntimeException;
use Carbon\Carbon;
use App\Mail\Email;
use App\Models\User;
use App\Jobs\SendEmailJob;
use App\Services\BaseService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $data
     * 
     * @return User
     */
    public function signup(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = Crypt::encryptString(json_encode([
            'uuid' => $user->uuid,
            'expires_at' => now()->addMinutes(30)->timestamp,
        ]));

        SendEmailJob::dispatch(
            new Email([
                'subject' => 'Email Confirmation',
                'to' => $user->email,
                'view' => 'emails.confirmation',
                'content' => [
                    'token' => $token,
                ],
            ])
        )->afterCommit();

        return $user;
    }

     /**
     * Verify email
     *
     * @param string $token
     * 
     * @return User
     */
    public function verifyEmail($token): User
    {
        try {
            $payload = json_decode(Crypt::decryptString($token), true);
        } catch (\Throwable $e) {
            throw new AppRuntimeException('', 'Invalid token');
        }

        if (
            empty($payload['uuid']) ||
            empty($payload['expires_at']) ||
            now()->timestamp > $payload['expires_at']
        ) {
            throw new AppRuntimeException('Token expired or invalid');
        }

        $user = User::where('uuid', $payload['uuid'])->firstOrFail();

        if ($user->email_verified_at) {
            throw new AppRuntimeException('Email already verified');
        }

        $user->update([
            'email_verified_at' => now(),
        ]);

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
}

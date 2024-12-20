<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->uuid,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'auth_token' => $this->when($request->is('api/login'), $this->auth_token)
            ]
        ];
    }
    
    /**
     * Add extra data to the response
     *
     * @param Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        return [
            'success' => true
        ];
    }
}

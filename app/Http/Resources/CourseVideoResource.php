<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class CourseVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'path' => $this->path,
            'order_no' => $this->order_no,
            'duration' => $this->duration
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

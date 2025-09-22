<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
            'modules' => CourseModuleResource::collection($this->modules)
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

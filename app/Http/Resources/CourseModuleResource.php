<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseModuleResource extends JsonResource
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
            'title' => $this->title,
            'order' => $this->order,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
            'lessons' => CourseModuleLessonResource::collection($this->lessons)
        ];
    }
}

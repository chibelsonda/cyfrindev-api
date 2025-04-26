<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseModuleLessonResource extends JsonResource
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
            'duration' => $this->duration,
            'video_url' => $this->video_url,
            'notes' => $this->notes,
            'order' => $this->order,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y')
        ];
    }
}

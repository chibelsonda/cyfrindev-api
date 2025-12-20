<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseModule;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class CourseModuleService extends BaseService
{ 
    /**
     * Get course modules by course UUID
     *
     * @param string $uuid
     * @return Collection
     */
    public function getCourseModulesByUuid(string $uuid): Collection
    {
        $course = Course::where('uuid', $uuid)->first();

        if (! $course) {
            throw new NotFoundException('Course not found');
        }

        $modules = CourseModule::where('course_id', $course->id)
            ->orderBy('order')
            ->get();

        if ($modules->isEmpty()) {
            throw new NotFoundException('No modules found for this course');
        }

        return $modules;
    }
}
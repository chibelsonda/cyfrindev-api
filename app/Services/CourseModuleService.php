<?php

namespace App\Services;

use App\Exceptions\AppRuntimeException;
use App\Models\Course;
use App\Models\CourseModule;
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
            throw new AppRuntimeException('Course not found');
        }

        $modules = CourseModule::where('course_id', $course->id)
            ->orderBy('order')
            ->get();

        if ($modules->isEmpty()) {
            throw new AppRuntimeException('No modules found for this course');
        }

        return $modules;
    }
}
<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseVideo;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseModuleService extends BaseService
{ 
    /**
     * @var Course
     */
    private $course;

    public function __construct(private $uuid)
    {
        if ($uuid) {
            $this->course = Course::where('uuid', $uuid)->first();
        }
    }

    /**
     * Get courses
     *
     * @return Collection
     */
    public function getCourseVideos(): Collection
    {
        if (!$this->course) {
            throw new NotFoundHttpException('Course not found');
        }

        return CourseModule::where('course_id', $this->course->id)
            ->orderBy('order')
            ->get();
    }
}
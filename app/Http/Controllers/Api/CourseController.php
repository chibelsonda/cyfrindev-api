<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseController extends BaseController
{
    /**
     * @var CourseService
     */
    private CourseService $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService(request()->route('uuid'));    
    }

    /**
     * Get courses
     *
     * @return ResourceCollection
     */
    public function getCourses(): ResourceCollection
    {
        $courses = $this->courseService->getCourses();

        return CourseResource::collection($courses);
    }

    /**
     * Get course
     *
     * @return CourseResource
     */
    public function getCourse(): CourseResource
    {
        $course = $this->courseService->getCourse();

        return (new CourseResource($course));
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

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

        return CourseResource::collection($courses)
            ->additional(['success' => true]);
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

    /**
     * Create course
     *
     * @param CreateCourseRequest $request
     * @return JsonResponse
     */
    public function createCourse(CreateCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return (new CourseResource($course))
            ->additional(['message' => 'Course has been created.'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Delete course
     *
     * @return JsonResponse
     */
    public function deleteCourse(): JsonResponse
    {
        $course = $this->courseService->deleteCourse();

        return (new CourseResource($course))
            ->additional(['message' => 'Course has been deleted.'])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CourseController extends BaseController
{
     /**
     * Constructor
     */
    public function __construct(
        private CourseService $courseService
    ) {}

    /**
     * Get courses
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $courses = $this->courseService->getCourses();

        return CourseResource::collection($courses)
            ->additional(['success' => true]);
    }

    /**
     * Get course
     *
     * @param Course $course
     * @return CourseResource
     */
    public function show(Course $course): CourseResource
    {
        return (new CourseResource($course));
    }

    /**
     * Create course
     *
     * @param CreateCourseRequest $request
     * @return JsonResponse
     */
    public function store(CreateCourseRequest $request): JsonResponse
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
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        $this->courseService->deleteCourse($course);

        return response()->json([
            'message' => 'Course has been deleted.',
            'success' => true,
        ], Response::HTTP_OK);
    }
}

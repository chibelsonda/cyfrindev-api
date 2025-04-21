<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;

class CourseController extends BaseController
{
    /**
     * @var CourseService
     */
    private CourseService $courseService; 

    /**
     * Get courses
     *
     * @return JsonResponse
     */
    public function getCourses(): JsonResponse
    {
        $response = $this->courseService->getCourses();

        return $this->sendResponse($response);
    }
}

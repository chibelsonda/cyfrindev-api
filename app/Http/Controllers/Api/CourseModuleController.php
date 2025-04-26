<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseModuleResource;
use App\Services\CourseModuleService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseModuleController extends Controller
{
    /**
     * @var CourseModuleService
     */
    private CourseModuleService $CourseModuleService;

    public function __construct()
    {
        $this->CourseModuleService = new CourseModuleService(request()->route('uuid'));    
    }

     /**
     * Get course videos
     *
     * @return ResourceCollection
     */
    public function getCourseVideos(): ResourceCollection
    {
        $courses = $this->CourseModuleService->getCourseVideos();

        return CourseModuleResource::collection($courses)
            ->additional(['success' => true]);
    }
}

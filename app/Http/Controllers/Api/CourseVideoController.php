<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseVideoResource;
use App\Services\CourseVideoService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseVideoController extends Controller
{
    /**
     * @var CourseVideoService
     */
    private CourseVideoService $courseVideoService;

    public function __construct()
    {
        $this->courseVideoService = new CourseVideoService(request()->route('uuid'));    
    }

     /**
     * Get course videos
     *
     * @return ResourceCollection
     */
    public function getCourseVideos(): ResourceCollection
    {
        $courses = $this->courseVideoService->getCourseVideos();

        return CourseVideoResource::collection($courses)
            ->additional(['success' => true]);
    }
}

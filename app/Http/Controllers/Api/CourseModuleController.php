<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseModuleResource;
use App\Services\CourseModuleService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseModuleController extends Controller
{
    public function __construct(
        private CourseModuleService $courseModuleService
    ) {}

     /**
     * Get course modules by uuid
     *
     * @return ResourceCollection
     */
    public function getCourseModulesByUuid(): ResourceCollection
    {
        $modules = $this->courseModuleService->getCourseModulesByUuid(request('uuid'));

        return CourseModuleResource::collection($modules)
            ->additional(['success' => true]);
    }
}

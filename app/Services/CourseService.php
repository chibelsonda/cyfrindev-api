<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService extends BaseService
{ 
    /**
     * Get users
     *
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return Course::all();
    }

}
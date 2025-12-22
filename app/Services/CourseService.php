<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService extends BaseService
{ 
    /**
     * Get courses
     *
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return Course::with('modules')->get();
    }

    /**
     * Create course
     *
     * @param array $data
     * @return Course
     */
    public function createCourse(array $data): Course
    {
        $course = Course::create($data);

        return $course->refresh();
    }

     /**
     * Delete course
     *
     * @param Course $course
     * @return void
     */
    public function deleteCourse(Course $course): void
    {
        $course->delete();
    }

}
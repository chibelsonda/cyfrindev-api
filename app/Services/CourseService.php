<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService extends BaseService
{ 
    /**
     * @var Course
     */
    private $course;

    public function __construct(private $id)
    {
        if ($id) {
            $this->course = Course::where('uuid', $id)->first();
        }
    }

    /**
     * Get courses
     *
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return Course::all();
    }

    /**
     * Get course
     *
     * @return Course|null
     */
    public function getCourse(): Course|null
    {
        if (!$this->course){
            return null;
        }

        return Course::find($this->course->id);
    }

}
<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseService extends BaseService
{ 
    /**
     * @var Course
     */
    private $course;

    public function __construct(private $uuid)
    {
        if ($uuid) {
            $this->course = Course::where('uuid', $uuid)->first();
        }
    }

    /**
     * Get courses
     *
     * @return Collection
     */
    public function getCourses(): Collection
    {
        return Course::select('*')->with('modules')->get();
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse(): Course
    {
        if (!$this->course){
            throw new NotFoundHttpException('Course not found');
        }

        return Course::find($this->course->id);
    }


    /**
     * Create course
     *
     * @param array $course
     * @return Course
     */
    public function createCourse(array $course): Course
    {
        return Course::create($course);
    }

     /**
     * Delete course
     *
     * @return Course
     */
    public function deleteCourse(): Course
    {
        if (!$this->course){
            throw new NotFoundHttpException('Course not found');
        }

        $course = Course::find($this->course->id);
        
        $course->delete();

        return $course;
    }

}
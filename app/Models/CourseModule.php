<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'course_id',
        'title',
        'order',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id'
    ];

    public function lessons()
    {
        return $this->hasMany(CourseModuleLesson::class, 'course_module_id', 'id')
            ->orderBy('course_module_lessons.order');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            $course->lessons()->delete();
        });
    }
}

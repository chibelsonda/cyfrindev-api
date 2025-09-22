<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'title',
        'description',
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

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id', 'id')
            ->with('lessons')
            ->orderBy('order');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            $course->modules()->delete();
        });
    }
}

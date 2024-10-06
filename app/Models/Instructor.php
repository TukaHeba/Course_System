<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'experience',
        'specialty'
    ];

    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'experience' => 'integer',
    ];

    /**
     * Define a many-to-many relationship with Course.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_instructor')->withTimestamps();
    }

    /**
     * Define a one-to-one relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a has-many-through relationship with students through out CourseInstructor.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function students()
    {
        return $this->hasManyThrough(
            CourseStudent::class,
            CourseInstructor::class,
            'instructor_id',
            'course_id',
            'id',
            'course_id',
        );
    }

    /**
     * Assign multiple courses to the instructor by their IDs.
     * 
     * @param array $courseIds
     * @return void
     */
    public function assignCourses(array $courseIds)
    {
        $this->courses()->syncWithoutDetaching($courseIds);
    }
}

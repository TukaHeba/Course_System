<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email'
    ];

    /**
     * Define a many-to-many relationship with Course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')->withTimestamps();
    }

    /**
     * Register the student in a course or more.
     * 
     * @param array $courseIds
     * @return void
     */
    public function register(array $courseIds)
    {
        $this->courses()->syncWithoutDetaching($courseIds);
    }
}

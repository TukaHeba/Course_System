<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start_date'
    ];

    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'start_date' => 'date'
    ];

    /**
     * Accessor for formatted start date.
     * 
     * @return string
     */
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    /**
     * Mutator for setting start date.
     * 
     * @param string $value
     * @return void
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }

    /**
     * Define a many-to-many relationship with Instructor.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'course_instructor')->withTimestamps();
    }

    /**
     * Define a many-to-many relationship with Student.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')->withTimestamps();
    }

    /**
     * Assign multiple instructors to the course by their IDs.
     *
     * @param array $instructorIds
     * @return void
     */
    public function assignInstructors(array $instructorIds)
    {
        $this->instructors()->syncWithoutDetaching($instructorIds);
    }
}

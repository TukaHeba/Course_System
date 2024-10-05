<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    /**
     * This model table's name
     * 
     * @var string
     */
    protected $table = 'course_student';
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseInstructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 1,
        ]);

        CourseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 2,
        ]);

        CourseInstructor::create([
            'course_id' => 3,
            'instructor_id' => 3,
        ]);

        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 1,
        ]);

        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 2,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 3,
        ]);
    }
}

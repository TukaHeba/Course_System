<?php

namespace Database\Seeders;

use App\Models\CourseStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseStudent::create([
            'course_id' => 1,
            'student_id' => 1,
        ]);
        CourseStudent::create([
            'course_id' => 1,
            'student_id' => 2,
        ]);
        CourseStudent::create([
            'course_id' => 1,
            'student_id' => 3,
        ]);

        CourseStudent::create([
            'course_id' => 2,
            'student_id' => 4,
        ]);
        CourseStudent::create([
            'course_id' => 2,
            'student_id' => 3,
        ]);

        CourseStudent::create([
            'course_id' => 3,
            'student_id' => 5,
        ]);
        CourseStudent::create([
            'course_id' => 3,
            'student_id' => 6,
        ]);

        CourseStudent::create([
            'course_id' => 4,
            'student_id' => 2,
        ]);
        CourseStudent::create([
            'course_id' => 4,
            'student_id' => 1,
        ]);
    }
}

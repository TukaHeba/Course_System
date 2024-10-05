<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'Course 1',
            'description' => 'Description of Course 1',
            'start_date' => '2024-01-01',
        ]);

        Course::create([
            'title' => 'Course 2',
            'description' => 'Description of Course 2',
            'start_date' => '2024-02-01',
        ]);

        Course::create([
            'title' => 'Course 3',
            'description' => 'Description of Course 3',
            'start_date' => '2024-03-01',
        ]);

        Course::create([
            'title' => 'Course 4',
            'description' => 'Description of Course 4',
            'start_date' => '2024-04-01',
        ]);
    }
}

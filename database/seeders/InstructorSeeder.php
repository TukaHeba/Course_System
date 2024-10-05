<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instructor::create([
            'name' => 'Tuka',
            'experience' => 5,
            'specialty' => 'Programming',
        ]);

        Instructor::create([
            'name' => 'Heba',
            'experience' => 10,
            'specialty' => 'Mathematics',
        ]);

        Instructor::create([
            'name' => 'Sarah',
            'experience' => 3,
            'specialty' => 'Design',
        ]);
    }
}

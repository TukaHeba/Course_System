<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Student A',
            'email' => 'studenta@gmail.com',
        ]);

        Student::create([
            'name' => 'Student B',
            'email' => 'studentb@gmail.com',
        ]);

        Student::create([
            'name' => 'Student C',
            'email' => 'studentc@gmail.com',
        ]);
        
        Student::create([
            'name' => 'Student D',
            'email' => 'studentd@gmail.com',
        ]);

        Student::create([
            'name' => 'Student E',
            'email' => 'studente@gmail.com',
        ]);

        Student::create([
            'name' => 'Student F',
            'email' => 'studentf@gmail.com',
        ]);
        
    }
}

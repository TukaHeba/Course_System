<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Instructor 1',
            'email' => 'instructor1@gmail.com',
            'password' => '12345678',
            'type' => 'instructor',
        ]);

        User::create([
            'name' => 'Instructor 2',
            'email' => 'instructor2@gmail.com',
            'password' => '12345678',
            'type' => 'instructor',
        ]);

        User::create([
            'name' => 'Student 1',
            'email' => 'student1@gmail.com',
            'password' => '12345678',
            'type' => 'student',
        ]);
        User::create([
            'name' => 'Student 2',
            'email' => 'student2@gmail.com',
            'password' => '12345678',
            'type' => 'student',
        ]);
        User::create([
            'name' => 'Student 3',
            'email' => 'student3@gmail.com',
            'password' => '12345678',
            'type' => 'student',
        ]);
    }
}

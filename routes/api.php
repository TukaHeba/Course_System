<?php

use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

///===== Course Routes =====///
Route::controller(CourseController::class)->group(function () {
    // List all students
    Route::get('/courses/{id}/students',  'listStudents');

    // List all instructors
    Route::get('/courses/{id}/instructors',  'listInstructors');

    // Assign instructors
    Route::post('/courses/{id}/instructors',  'assignInstructors');
});
Route::apiResource('courses', CourseController::class);


///===== Instructor Routes =====///
Route::controller(InstructorController::class)->group(function () {
    // List all students
    Route::get('/instructors/{id}/students', 'listStudents');

    // List all courses
    Route::get('/instructors/{id}/courses', 'listCourses');

    // Assign courses
    Route::post('/instructors/{id}/courses', 'assignCourses');
});
Route::apiResource('instructors', InstructorController::class);


///===== Student Routes =====///
Route::controller(StudentController::class)->group(function () {
    // List all courses
    Route::get('/students/{id}/courses', 'listCourses');

    // Register in courses
    Route::post('/students/{id}/courses', 'registerInCourses');
});
Route::apiResource('students', StudentController::class);

<?php

namespace App\Http\Controllers\Api;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Services\InstructorService;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Resources\StudentResource;
use App\Http\Resources\InstructorResource;
use App\Http\Requests\Instructor\StoreInstructorRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Instructor\UpdateInstructorRequest;
use App\Http\Resources\CourseResource;

class InstructorController extends Controller
{
    protected $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $instructos = $this->instructorService->listAllInstructors();
            return ApiResponseService::success(InstructorResource::collection($instructos), 'Instructos retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorRequest $request)
    {
        $validated = $request->validated();

        try {
            $newInstructor = $this->instructorService->createInstructor($validated, $validated['courses']);
            return ApiResponseService::success(new InstructorResource($newInstructor), 'Instructor created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $instructor = $this->instructorService->showInstructor($id);
            return ApiResponseService::success(new InstructorResource($instructor), 'Instructor retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedInstructor = $this->instructorService->updateInstructor($id, $validated, $validated['courses'] ?? []);
            return ApiResponseService::success(new InstructorResource($updatedInstructor), 'Instructor updated successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->instructorService->deleteInstructor($id);
            return ApiResponseService::success(null, 'Instructor deleted successfully', 200);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * List all students of a course.
     */
    public function listStudents(string $id)
    {
        try {
            $students = $this->instructorService->listStudentsOfInstructor($id);
            return ApiResponseService::success(StudentResource::collection($students), 'Students retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * List all instructors of a course.
     */
    public function listCourses(string $id)
    {
        try {
            $corses = $this->instructorService->listCoursesOfInstructor($id);
            return ApiResponseService::success(CourseResource::collection($corses), 'Courses retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Assign instructors to a course.
     */
    public function assignCourses(Request $request, string $id)
    {
        $validated = $request->validate([
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id'
        ]);

        try {
            $course = $this->instructorService->assignCoursesToInstructors($id, $validated['courses']);
            return ApiResponseService::success(new CourseResource($course), 'Courses assigned successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    // public function showStudents($instructorId)
    // {
    //     $instructor = Instructor::findOrFail($instructorId);
    //     $students = $instructor->students;

    //     return response()->json([
    //         'instructor' => $instructor->name,
    //         'students' => $students,
    //     ]);
    // }

    // public function showStudents($instructorId)
    // {
    //     $instructor = Instructor::findOrFail($instructorId);
    //     $students = $instructor->students;
    //     $response = [
    //         'instructor' => $instructor->name,
    //         'courses' => [],
    //     ];

    //     // Loop through each course
    //     foreach ($instructor->courses as $course) {
    //         $students = [];

    //         // Loop through each student in the current course
    //         foreach ($course->students as $student) {
    //             $students[] = [
    //                 'student_id' => $student->id,
    //                 'student_name' => $student->name,
    //             ];
    //         }

    //         // Add the course information along with students to the response
    //         $response['courses'][] = [
    //             'course' => $course->title,
    //             'students' => $students,
    //         ];
    //     }

    //     return response()->json($response);
    // }

    // public function showStudents($instructorId)
    // {
    //     // Find the instructor by ID
    //     $instructor = Instructor::findOrFail($instructorId);

    //     // Retrieve all courses associated with the instructor and eager load students
    //     $courses = $instructor->courses()->with('students')->get(); 

    //     // Prepare the response array
    //     $response = [
    //         'instructor' => $instructor->name,
    //         'courses' => [],
    //     ];

    //     // Loop through each course and its students
    //     foreach ($courses as $course) {
    //         $response['courses'][] = [
    //             'course' => $course->title, // Assuming there is a title attribute in the Course model
    //             'students' => $course->students->map(function ($student) {
    //                 return [
    //                     'student_id' => $student->id,
    //                     'student_name' => $student->name, // Assuming you have a name field in the Student model
    //                     // Remove the laravel_through_key to exclude it from the response
    //                 ];
    //             }),
    //         ];
    //     }

    //     return response()->json($response);
    // }


}

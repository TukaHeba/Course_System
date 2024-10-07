<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $students = $this->studentService->listAllStudents();
            return ApiResponseService::success(StudentResource::collection($students), 'Students retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        try {
            $newStudent = $this->studentService->createStudent($validated, $validated['courses']);
            return ApiResponseService::success(new StudentResource($newStudent), 'Students created successfully', 201);
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
            $student = $this->studentService->showStudent($id);
            return ApiResponseService::success(new StudentResource($student), 'Student retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedStudent = $this->studentService->updateStudent($id, $validated, $validated['courses'] ?? []);
            return ApiResponseService::success(new StudentResource($updatedStudent), 'Student updated successfully', 200);
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
            $this->studentService->deleteStudent($id);
            return ApiResponseService::success(null, 'Student deleted successfully', 200);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * List all courses of an instruuctore.
     */
    public function listCourses(string $id)
    {
        try {
            $corses = $this->studentService->listCoursesOfStudent($id);
            return ApiResponseService::success(CourseResource::collection($corses), 'Courses retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Assign courses to an instructor.
     */
    public function registerInCourses(Request $request, string $id)
    {
        $validated = $request->validate([
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id'
        ]);

        try {
            $student = $this->studentService->registerStudentInCourses($id, $validated['courses']);
            return ApiResponseService::success(new StudentResource($student), 'Courses assigned successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }
}

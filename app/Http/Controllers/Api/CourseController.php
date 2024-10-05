<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\InstructorResource;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courses = $this->courseService->listAllCourses();
            return ApiResponseService::success(CourseResource::collection($courses), 'Courses retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        try {
            $newCourse = $this->courseService->createCourse($validated, $validated['instructors']);
            return ApiResponseService::success(new CourseResource($newCourse), 'Course created successfully', 201);
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
            $course = $this->courseService->showCourse($id);
            return ApiResponseService::success(new CourseResource($course), 'Course retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedCourse = $this->courseService->updateCourse($id, $validated, $validated['instructors'] ?? []);
            return ApiResponseService::success(new CourseResource($updatedCourse), 'Course updated successfully', 200);
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
            $this->courseService->deleteCourse($id);
            return ApiResponseService::success(null, 'Course deleted successfully', 200);
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
            $students = $this->courseService->listStudentsOfCourse($id);
            return ApiResponseService::success(StudentResource::collection($students), 'Students retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * List all instructors of a course.
     */
    public function listInstructors(string $id)
    {
        try {
            $instructors = $this->courseService->listInstructorsOfCourse($id);
            return ApiResponseService::success(InstructorResource::collection($instructors), 'Instructors retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Assign instructors to a course.
     */
    public function assignInstructors(Request $request, string $id)
    {
        $validated = $request->validate([
            'instructors' => 'required|array',
            'instructors.*' => 'exists:instructors,id'
        ]);

        try {
            $course = $this->courseService->assignInstructorsToCourse($id, $validated['instructors']);
            return ApiResponseService::success(new CourseResource($course), 'Instructors assigned successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }
}

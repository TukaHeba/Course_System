<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseService
{
    /**
     * Retrieve all courses with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllCourses()
    {
        try {
            $courses = Course::with('instructors')->paginate(5);

            return $courses;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve courses: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new course with the provided data.
     * 
     * @param array $data
     * @param array $instructorIds
     * @throws \Exception
     * @return Course|\Illuminate\Database\Eloquent\Model
     */
    public function createCourse(array $data, array $instructorIds)
    {
        try {
            $course = Course::create($data);
            $course->assignInstructors($instructorIds);
            $course->load('instructors');

            return $course;
        } catch (\Exception $e) {
            Log::error('Course creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single course.
     * 
     * @param string $id
     * @throws \Exception
     * @return Course|Course[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showCourse(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->load('instructors');

            return $course;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing course with the provided data.
     * 
     * @param string $id
     * @param array $data
     * @param array $instructorIds
     * @throws \Exception
     * @return Course|Course[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function updateCourse(string $id, array $data, array $instructorIds = [])
    {
        try {
            $course = Course::findOrFail($id);
            $course->update(array_filter($data));

            $validInstructorIds = array_filter($instructorIds, function ($instructorId) {
                return !is_null($instructorId);
            });

            if (!empty($validInstructorIds)) {
                $course->instructors()->sync($validInstructorIds);
            }

            $course->load('instructors');

            return $course;
        } catch (\Exception $e) {
            Log::error('Failed to update course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a course.
     * 
     * @param string $id
     * @throws \Exception
     * @return bool|mixed|null
     */
    public function deleteCourse(string $id)
    {
        try {
            $course = Course::findOrFail($id);

            return $course->delete();
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to delete course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List all students of a course.
     * 
     * @param string $courseId
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listStudentsOfCourse(string $courseId)
    {
        try {
            $course = Course::with('students')->findOrFail($courseId);

            return $course->students;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve students for course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List all instructors of a course.
     * 
     * @param string $courseId
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listInstructorsOfCourse(string $courseId)
    {
        try {
            $course = Course::with('instructors')->findOrFail($courseId);


            return $course->instructors;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve instructors for course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Assign instructors to a course by their IDs.
     * 
     * @param string $courseId
     * @param array $instructorIds
     * @throws \Exception
     * @return Course|\Illuminate\Database\Eloquent\Model
     */
    public function assignInstructorsToCourse(string $courseId, array $instructorIds)
    {
        try {
            $course = Course::findOrFail($courseId);
            $course->assignInstructors($instructorIds);
            $course->load('instructors');

            return $course;
        } catch (\Exception $e) {
            Log::error('Failed to assign instructors to course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}

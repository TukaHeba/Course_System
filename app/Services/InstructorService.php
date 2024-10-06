<?php

namespace App\Services;

use App\Models\Instructor;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InstructorService
{
    /**
     * Retrieve all instructors with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllInstructors()
    {
        try {
            $instructors = Instructor::with('courses')->paginate(5);

            return $instructors;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new instructor with the provided data.
     * 
     * @param array $data
     * @param array $courseIds
     * @throws \Exception
     * @return Instructor|\Illuminate\Database\Eloquent\Model
     */
    public function createInstructor(array $data, array $courseIds)
    {
        try {
            $instructor = Instructor::create($data);
            $instructor->assignCourses($courseIds);
            $instructor->load('courses');

            return $instructor;
        } catch (\Exception $e) {
            Log::error('Instructor creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single instructor.
     * 
     * @param string $id
     * @throws \Exception
     * @return Instructor|Instructor[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showInstructor(string $id)
    {
        try {
            $instructor = Instructor::findOrFail($id);
            $instructor->load('courses');

            return $instructor;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing instructor with the provided data.
     * 
     * @param string $id
     * @param array $data
     * @param array $courseIds
     * @throws \Exception
     * @return Instructor|Instructor[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function updateInstructor(string $id, array $data, array $courseIds = [])
    {
        try {
            $instructor = Instructor::findOrFail($id);
            $instructor->update(array_filter($data));

            $validCourseIds = array_filter($courseIds, function ($courseId) {
                return !is_null($courseId);
            });

            if (!empty($validCourseIds)) {
                $instructor->courses()->sync($validCourseIds);
            }

            $instructor->load('courses');

            return $instructor;
        } catch (\Exception $e) {
            Log::error('Failed to update instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a instructor.
     * 
     * @param string $id
     * @throws \Exception
     * @return bool|mixed|null
     */
    public function deleteInstructor(string $id)
    {
        try {
            $instructor = Instructor::findOrFail($id);

            return $instructor->delete();
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to delete instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List all students of an instructor.
     * 
     * @param string $instructorId
     * @throws \Exception
     * @return mixed
     */
    public function listStudentsOfInstructor(string $instructorId)
    {
        try {
            $instructor = Instructor::with('students')->findOrFail($instructorId);

            return $instructor->students;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve students for instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List all courses of an instructor.
     * 
     * @param string $instructorId
     * @throws \Exception
     * @return mixed
     */
    public function listCoursesOfInstructor(string $instructorId)
    {
        try {
            $instructor = Instructor::with('courses')->findOrFail($instructorId);

            return $instructor->courses;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve instructors for course: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Assign courses to an instructor by their IDs.
     * 
     * @param string $instructorId
     * @param array $courseIds
     * @throws \Exception
     * @return Instructor|Instructor[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function assignCoursesToInstructors(string $instructorId, array $courseIds)
    {
        try {
            $instructor = Instructor::findOrFail($instructorId);
            $instructor->assignCourses($courseIds);
            $instructor->load('courses');

            return $instructor;
        } catch (\Exception $e) {
            Log::error('Failed to assign courses to an instructor: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}

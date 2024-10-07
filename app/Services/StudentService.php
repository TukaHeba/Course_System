<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{
    /**
     * Retrieve all students with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllStudents()
    {
        try {
            $students = Student::with('courses')->paginate(5);

            return $students;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve students: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new student with the provided data.
     * 
     * @param array $data
     * @param array $courseIds
     * @throws \Exception
     * @return Student|\Illuminate\Database\Eloquent\Model
     */
    public function createStudent(array $data, array $courseIds)
    {
        try {
            $student = Student::create($data);
            $student->register($courseIds);
            $student->load('courses');

            return $student;
        } catch (\Exception $e) {
            Log::error('student creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single student.
     * 
     * @param string $id
     * @throws \Exception
     * @return Student|Student[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showStudent(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->load('courses');

            return $student;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve student: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing student with the provided data.
     * 
     * @param string $id
     * @param array $data
     * @param array $courseIds
     * @throws \Exception
     * @return Student|Student[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function updateStudent(string $id, array $data, array $courseIds = [])
    {
        try {
            $student = Student::findOrFail($id);
            $student->update(array_filter($data));

            $validCourseIds = array_filter($courseIds, function ($courseId) {
                return !is_null($courseId);
            });

            if (!empty($validCourseIds)) {
                $student->courses()->sync($validCourseIds);
            }

            $student->load('courses');

            return $student;
        } catch (\Exception $e) {
            Log::error('Failed to update student: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a student.
     * 
     * @param string $id
     * @throws \Exception
     * @return bool|mixed|null
     */
    public function deleteStudent(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            return $student->delete();
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to delete student: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List all courses of a student.
     * 
     * @param string $instructorId
     * @throws \Exception
     * @return mixed
     */
    public function listCoursesOfStudent(string $studentId)
    {
        try {
            $student = Student::with('courses')->findOrFail($studentId);

            return $student->courses;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve this student courses: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Register student in course or more.
     * 
     * @param string $studentId
     * @param array $courseIds
     * @throws \Exception
     * @return Student|Student[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function registerStudentInCourses(string $studentId, array $courseIds)
    {
        try {
            $student = Student::findOrFail($studentId);
            $student->register($courseIds);
            $student->load('courses');

            return $student;
        } catch (\Exception $e) {
            Log::error('Failed to register this student in courses: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}

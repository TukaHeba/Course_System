<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * Retrieve all users with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllUsers()
    {
        try {
            return User::paginate(5);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve users: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new user with the provided data.
     * 
     * @param array $data
     * @throws \Exception
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function createUser(array $data)
    {
        try {
            return User::create($data);
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single user.
     * 
     * @param string $id
     * @throws \Exception
     * @return User
     */
    public function showUser(string $id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('User not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to retrieve user: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing user with the provided data.
     * 
     * @param string $id
     * @param array $data
     * @throws \Exception
     * @return User
     */
    public function updateUser(string $id, array $data)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(array_filter($data));

            return $user;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('User not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to update user: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a user.
     * 
     * @param string $id
     * @throws \Exception
     * @return bool
     */
    public function deleteUser(string $id)
    {
        try {
            $user = User::findOrFail($id);

            return $user->delete();
        } catch (ModelNotFoundException $e) {
            throw new \Exception('User not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to delete user: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}

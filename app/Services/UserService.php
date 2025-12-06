<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\Paginator;

class UserService
{
    /**
     * Retrieve list of users with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = User::query();

        // Scope by establishment
        $establishmentId = $filters['establishment_id'] ?? session('establishment_id') ?? auth()->user()?->establishment_id;
        if ($establishmentId) {
            $query = $query->where('establishment_id', $establishmentId);
        }

        if (!empty($withRelations)) {
            $query = $query->with($withRelations);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query = $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        if (!empty($filters['department_id'])) {
            $query = $query->where('department_id', $filters['department_id']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single user by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\User|null
     */
    public function find(int $id, array $with = []): ?User
    {
        $query = User::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User|null
     */
    public function update(int $id, array $data): ?User
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    /**
     * Delete a user
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}

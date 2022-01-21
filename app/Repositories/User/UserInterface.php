<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    /**
     * Return all users
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Return a specific user
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User;

    /**
     * Return a query for searching users
     *
     * @param array $query
     */
    public function where(array $query);

    /**
     * Create a new user
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool;

    /**
     * Update a specific user
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * Delete a specific user
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

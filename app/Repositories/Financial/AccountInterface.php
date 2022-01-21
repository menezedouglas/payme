<?php

namespace App\Repositories\Financial;

use App\Models\Financial\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountInterface
{

    /**
     * Return all accounts
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Return a specific account
     *
     * @param int $id
     * @return Account|null
     */
    public function find(int $id): ?Account;

    /**
     * Create a new account
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool;

    /**
     * Update a specific account
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a specific account
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

}

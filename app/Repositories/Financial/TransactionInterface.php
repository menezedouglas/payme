<?php

namespace App\Repositories\Financial;

use App\Models\Financial\Transaction;
use Illuminate\Database\Eloquent\Collection;

interface TransactionInterface
{

    /**
     * Return all transactions
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Return a specific transaction
     *
     * @param int $id
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction;

    /**
     * Create a new transaction
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool;


    /**
     * Delete a specific transaction
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

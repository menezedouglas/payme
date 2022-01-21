<?php

namespace App\Repositories\Financial;

use App\Models\Financial\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountInterface
{

    /**
     * Return all accounts
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Account::all();
    }

    /**
     * Return a specific account
     *
     * @param int $id
     * @return Account|null
     */
    public function find(int $id): ?Account
    {
        return Account::find($id);
    }

    /**
     * Create a new account
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $account = new Account();

        $account->user_id = $data['user_id'];
        $account->balance_value = $data['balance_value'];

        return !!$account->save();
    }

    /**
     * Update a specific account
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        if(!$account = $this->find($id))
            abort(404, 'A conta não foi encontrada');

        $account->balance_value = $data['balance_value'];

        return !!$account->save();
    }

    /**
     * Delete a specific account
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if(!$account = $this->find($id))
            abort(404, 'A conta não foi encontrada');

        return !!$account->delete();
    }

    /**
     * Convert database data format to float value
     *
     * @param int $value
     * @return float
     */
    public static function dataToFloat(int $value): float
    {
        return round($value / 100, 2);
    }

    /**
     * Convert float value to database data format
     *
     * @param float $value
     * @return int
     */
    public static function floatToData(float $value): int
    {
        return round($value, 2) * 100;
    }
}

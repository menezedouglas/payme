<?php

namespace App\Repositories\Financial;

use App\Exceptions\Transaction\TransactionNotFoundException;
use App\Models\Financial\Transaction;

use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionInterface
{

    /**
     * Account Repository
     *
     * @var AccountInterface
     */
    protected AccountInterface $account;

    /**
     * Constructor method
     *
     * @param AccountInterface $account
     */
    public function __construct(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Return all transactions
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Transaction::all();
    }

    /**
     * Return a specific transaction
     *
     * @param int $id
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction
    {
        return Transaction::find($id);
    }

    /**
     * Create a new transaction
     *
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        $transaction = new Transaction();

        $transaction->payer_account_id = $data['payer_account_id'];
        $transaction->payee_account_id = $data['payee_account_id'];
        $transaction->amount = $data['amount'];
        $transaction->status = 'pendente';

        $transaction->save();

        return $transaction;
    }

    /**
     * Delete a specific account
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if(!$transaction = $this->find($id))
            throw new TransactionNotFoundException();

        return !!$transaction->delete();
    }

}

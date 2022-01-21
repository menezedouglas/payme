<?php

namespace App\Repositories\Financial;

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
     * @return bool
     */
    public function create(array $data): bool
    {
        $transaction = new Transaction();

        $transaction->payer_account_id = $data['payer_account_id'];
        $transaction->payee_account_id = $data['payee_account_id'];
        $transaction->value = $data['value'];

        return !!$transaction->save();
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
            abort(404, 'A transação não foi encontrada');

        $payerAccount = $this->account->find($transaction->payer_account_id);
        $payeeAccount = $this->account->find($transaction->payee_account_id);

        $payerAccount->balance_value += $transaction->value;
        $payeeAccount->balance_value -= $transaction->value;

        $payerAccount->save();
        $payeeAccount->save();

        return !!$transaction->delete();
    }

}

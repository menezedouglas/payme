<?php

namespace App\Services\Financial;

use App\Models\Financial\Transaction;
use App\Models\User;
use App\Repositories\Financial\{
    AccountInterface,
    AccountRepository,
    TransactionInterface
};

class Transference
{

    /**
     * Account Repositorie Interface
     *
     * @var AccountInterface $account
     */
    protected AccountInterface $account;

    /**
     * Transaction Repositorie Interface
     *
     * @var TransactionInterface $transaction
     */
    protected TransactionInterface $transaction;

    /**
     * Constructor Method
     *
     * @param AccountInterface $account
     * @param TransactionInterface $transaction
     */
    public function __construct(AccountInterface $account, TransactionInterface $transaction)
    {
        $this->account = $account;
        $this->transaction = $transaction;
    }

    /**
     * Execute the transaction
     *
     * @return bool
     */
    public function execute(Transaction $transaction): bool
    {
        $payerAccount = $transaction->payerAccount;
        $payeeAccount = $transaction->payeeAccount;

        $payerAccount->balance_value -= $transaction->amount;
        $payeeAccount->balance_value += $transaction->amount;

        $payerAccount->save();
        $payeeAccount->save();

        $transaction->status = 'complete';
        return !!$transaction->save();
    }

    /**
     * Rollback the specified transaction
     *
     * @param Transaction $transaction
     * @return bool
     */
    public function rollback(Transaction $transaction): bool
    {
        $value = $transaction->value;

        $payerAccount = $transaction->payerAccount;
        $payeeAccount = $transaction->payeeAccount;

        $payerAccount->balance_value += $value;
        $payeeAccount->balance_value -= $value;

        $payerAccount->save();
        $payeeAccount->save();

        $transaction->status = 'reverted';
        $transaction->save();

        return !!$this->transaction->delete($transaction->id);
    }

}

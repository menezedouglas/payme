<?php

namespace App\Services\Financial;

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
     *
     */
    public function make(User $from, User $to, int $amount): bool
    {
        $value = AccountRepository::floatToData((float) $amount);

        $payerAccount = $from->account;
        $payeeAccount = $to->account;

        $payerAccount->balance_value -= $value;
        $payeeAccount->balance_value += $value;

        $payerAccount->save();
        $payeeAccount->save();

        return $this->transaction->create([
            'value' => $value,
            'payer_account_id' => $from->account->id,
            'payee_account_id' => $to->account->id,
        ]);
    }

}

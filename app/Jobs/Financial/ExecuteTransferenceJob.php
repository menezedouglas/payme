<?php

namespace App\Jobs\Financial;

use App\Jobs\Job;
use App\Models\Financial\Transaction;
use App\Repositories\Financial\AccountRepository;
use Illuminate\Support\Facades\Http;

class ExecuteTransferenceJob extends Job
{

    /**
     * Transaction Model
     *
     * @var Transaction $transaction
     */
    protected Transaction $transaction;

    /**
     * Number of attempts to job
     *
     * @var int $tries
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payerAccount = $this->transaction->payerAccount;
        $payeeAccount = $this->transaction->payeeAccount;

        $payerAccount->balance_value -= $this->transaction->amount;
        $payeeAccount->balance_value += $this->transaction->amount;

        $payerAccount->save();
        $payeeAccount->save();

        $this->transaction->status = 'completa';

        $this->transaction->save();

        Http::post(env('URL_API_SEND_NOTIFY'), [
            'notify_type' => 'email',
            'from' => env('MAIL_FROM_ADDRESS'),
            'to' => $payeeAccount->owner->email,
            'subject' => env('APP_NAME') . " - Aviso de novo pagamento",
            'content' => "Você recebeu um pagamento de R$ " . AccountRepository::dataToFloat($this->transaction->amount),
        ]);
    }
}

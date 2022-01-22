<?php

namespace App\Jobs\Financial;

use App\Jobs\Job;
use App\Models\Financial\Transaction;

class TransferenceJob extends Job
{

    /**
     * Transaction Model
     *
     * @var Transaction $transaction
     */
    protected Transaction $transaction;

    /**
     * Transaction status
     *
     * @var string $status
     */
    protected string $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->status = 'executing';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

        } catch (\Exception $error) {

        }
    }
}

<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $table = 'financial_transactions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'payer_account_id',
        'payee_account_id',
        'amount',
        'status'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Change the status of transaction
     *
     * @param string $status
     * @return bool
     */
    public function updateStatus(string $status): bool
    {
        $this->status = $status;
        return !!$this->save();
    }

    /**
     * Return the payer of this transaction
     *
     * @return BelongsTo
     */
    public function payerAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payer_account_id', 'id');
    }

    /**
     * Return the payee of this transaction
     *
     * @return BelongsTo
     */
    public function payeeAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payee_account_id', 'id');
    }

}

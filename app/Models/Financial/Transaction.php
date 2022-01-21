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
        'value'
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

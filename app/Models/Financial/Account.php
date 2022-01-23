<?php

namespace App\Models\Financial;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $balance_value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Account extends Model
{

    protected $table = 'financial_accounts';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'balance_value',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Return the owner of this account
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Return payments of this account
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_account_id', 'id');
    }

    /**
     * Return receipts of this account
     *
     * @return HasMany
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_account_id', 'id');
    }
}

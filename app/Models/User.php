<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $cpf
 * @property int|null $cnpj
 * @property int $user_type_id
 */
class User extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'cpf',
        'cnpj',
        'user_type_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Generates the user full name
     *
     * @return string
     */
    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * Return a related user type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
    }

    /**
     * Return a specific user by their email address
     *
     * @param string $email
     * @return User
     */
    public static function findByEmail(string $email): User
    {
        return static::where('email', $email)->first();
    }

}

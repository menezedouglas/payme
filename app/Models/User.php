<?php

namespace App\Models;

use App\Models\Financial\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $cpf
 * @property int|null $cnpj
 * @property int $user_type_id
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'cpf',
        'cnpj',
        'user_type_id',
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


    /**
     * Return financial account of this user
     *
     * @return HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'user_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}

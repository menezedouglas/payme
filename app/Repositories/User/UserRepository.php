<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\UserType;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\UserType\UserTypeNotFoundException;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Financial\AccountInterface;

class UserRepository implements UserInterface
{

    /**
     * Account Repository Interface
     *
     * @var AccountInterface $account
     */
    protected AccountInterface $account;

    /**
     * Constructor Method
     *
     * @param AccountInterface $account
     */
    public function __construct(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Return all users
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * Return a specific user
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Return a query for searching users
     *
     * @param array $query
     */
    public function where(array $query)
    {
        return User::where($query);
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $userType = UserType::where([
            'cpf_required' => array_key_exists('cpf', $data) ? !!$data['cpf'] : false,
            'cnpj_required' => array_key_exists('cnpj', $data) ? !!$data['cnpj'] : false
        ])->first();

        if (!$userType)
            abort(404, 'Não foi possível identificar o tipo do usuário!');

        $user = new User();

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->cpf = $data['cpf'];
        $user->cnpj = array_key_exists('cnpj', $data) ? $data['cnpj'] : null;
        $user->user_type_id = $userType->id;
        $user->password = Hash::make($data['password']);

        $userSuccess = !!$user->save();

        $accountSuccess = $this->account->create([
            'user_id' => $user->id,
            'balance_value' => 0
        ]);

        return $userSuccess && $accountSuccess;
    }

    /**
     * Update a specific user
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {

        if (!$user = $this->find($id))
            abort(404, 'Não foi possível encontrar o usuário!');

        $userType = UserType::where([
            'cpf_required' => array_key_exists('cpf', $data) ? !!$data['cpf'] : false,
            'cnpj_required' => array_key_exists('cnpj', $data) ? !!$data['cnpj'] : false
        ])->first();

        if (!$userType)
            abort(404, 'Não foi possível identificar o tipo do usuário!');

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->cpf = $data['cpf'];
        $user->cnpj = array_key_exists('cnpj', $data) ? $data['cnpj'] : null;
        $user->user_type_id = $userType->id;

        return !!$user->save();

    }

    /**
     * Delete a specific user
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if(!$user = $this->find($id))
            abort(404, 'Não foi possível encontrar o usuário!');

        return !!$user->delete();
    }
}

<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\UserType;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\UserType\UserTypeNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{

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

        if ($user->save())
            return true;

        return false;
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

        $user->save();

        return true;
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

        if(!$user->delete())
            return false;

        return true;
    }
}

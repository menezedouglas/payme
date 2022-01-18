<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\UserType;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\UserType\UserTypeNotFoundException;

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
            'cpf_required' => !!$data['cpf'],
            'cnpj_required' => !!$data['cnpj']
        ])->first();

        if (!$userType)
            throw new UserTypeNotFoundException();

        $user = new User();

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->cpf = $data['cpf'];
        $user->cnpj = $data['cnpj'];
        $user->user_type_id = $userType->id;

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
            throw new UserNotFoundException();

        $userType = UserType::where([
            'cpf_required' => !!$data['cpf'],
            'cnpj_required' => !!$data['cnpj']
        ])->first();

        if (!$userType)
            throw new UserTypeNotFoundException();

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->cpf = $data['cpf'];
        $user->cnpj = $data['cnpj'];
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
            throw new UserNotFoundException();

        if(!$user->delete())
            return false;

        return true;
    }
}

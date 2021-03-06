<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $withCnpj = [true, false][rand(0, 1)];

        $userType = UserType::where([
            'cpf_required' => true,
            'cnpj_required' => $withCnpj
        ])->first();


        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => rand(10000000000, 99999999999),
            'cnpj' => $withCnpj ? rand(
                10000000000000,
                99999999999999
            ) : null,
            'user_type_id' => $userType->id,
            'password' => Hash::make('password')
        ];
    }
}

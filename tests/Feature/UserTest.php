<?php

use App\Models\User;

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function createUserWithOnlyCpf()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'password' => 'password'
        ]);

        $this->assertResponseOk();
    }

    /** @test */
    public function createUserWithCpfAndCNPJ()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'cnpj' => $user->cnpj,
            'password' => 'password'
        ])->assertResponseOk();
    }

    /** @test */
    public function getAllUsers()
    {
        /**
         * @var User
         */
        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', '/user')->assertResponseOk();
    }

    /** @test */
    public function getUserById()
    {
        $endpoint = '/user/:id';

        /**
         * @var User
         */
        $user = User::factory()->create();

        $users = $this->actingAs($user)->json('GET', '/user')->response->original->toArray();

        $user = $users[rand(
                min(
                    array_keys(
                        array_column($users, 'id')
                    )
                ),
                max(
                    array_keys(
                        array_column($users, 'id')
                    )
                )
            )];

        $response = $this->json('GET', str_replace(':id', $user['id'], $endpoint))->response->original->toArray();

        $this->assertTrue(
            $user['id'] === $response['id']
        );
    }

    /** @test */
    public function shouldBeWithFirstNameRequired()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => null,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'cnpj' => $user->cnpj,
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

    /** @test */
    public function shouldBeWithLastNameRequired()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => $user->first_name,
            'last_name' => null,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'cnpj' => $user->cnpj,
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

    /** @test */
    public function shouldBeWithEmailRequired()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => null,
            'cpf' => $user->cpf,
            'cnpj' => $user->cnpj,
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

    /** @test */
    public function shouldBeWithCpfRequired()
    {
        /**
         * @var User
         */
        $user = User::factory()->make();

        $this->json('POST', '/user', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'cpf' => null,
            'cnpj' => $user->cnpj,
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

}

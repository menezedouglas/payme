<?php

use App\Models\User;

class FinancialTest extends TestCase
{

    /** @test */
    public function getAccountData()
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

        $this->actingAs($user)->json('GET', '/financial');

        dd($this->response);

    }

    /** @test */
    public function CreateTransaction()
    {
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function RollbackTransaction()
    {
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function DeleteAccount()
    {

        /**
         * @var User
         */
        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', '/financial')->assertResponseOk();
    }

}

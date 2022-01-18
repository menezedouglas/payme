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

        $this->json('POST','/user/create', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'cpf' => $user->cpf
        ])->assertResponseOk();
    }

    /** @test */
    public function createUserWithCpfAndCNPJ()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function getAllUsers()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function getUserById()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function shouldBeWithFirstNameRequired()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function shouldBeWithLastNameRequired()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function shouldBeWithEmailRequired()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function shouldBeWithCpfRequiredForAnyUserType()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function shouldBeWithCnpjNullable()
    {
        $this->assertTrue(true);
    }
}

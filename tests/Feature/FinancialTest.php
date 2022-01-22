<?php

use App\Models\Financial\Account;
use App\Models\User;

class FinancialTest extends TestCase
{

    /** @test */
    public function getAccountData()
    {

        /**
         * User without financial account
         *
         * @var User $user
         */
        $user = User::factory()->create();

        Account::create([
            'user_id' => $user->id,
            'balance_value' => rand(0, 10000000000)
        ]);

        $this->actingAs($user)->json('GET', '/financial')->assertResponseOk();

    }

    /** @test */
    public function CreateTransaction()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function RollbackTransaction()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function DeleteAccount()
    {

        /**
         * User without financial account
         *
         * @var User $user
         */
        $user = User::factory()->create();

        Account::create([
            'user_id' => $user->id,
            'balance_value' => rand(0, 10000000000)
        ]);

        $this->actingAs($user)->json('DELETE', '/financial')->assertResponseOk();

    }

}

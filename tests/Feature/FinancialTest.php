<?php

use App\Models\Financial\Account;
use App\Models\Financial\Transaction;
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

    // /** @test */
    // public function CreateTransactionWithEmail()
    // {
    //     /**
    //      * Payer
    //      *
    //      * @var User $payer
    //      */
    //     $payer = User::factory()->create();

    //     /**
    //      * Only "cliente" is permissed send money
    //      */
    //     $payer->cnpj = null;
    //     $payer->save();

    //     /**
    //      * Payee
    //      *
    //      * @var User $payee
    //      */
    //     $payee = User::factory()->create();

    //     Account::create([
    //         'user_id' => $payer->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     Account::create([
    //         'user_id' => $payee->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     $this->actingAs($payer)->json('POST', '/financial/transaction/new', [
    //         'type' => 'email',
    //         'to' => $payee->email,
    //         'amount' => rand(0, 10000000000)
    //     ])->assertResponseOk();

    // }

    // /** @test */
    // public function CreateTransactionWithCPF()
    // {
    //     /**
    //      * Payer
    //      *
    //      * @var User $payer
    //      */
    //     $payer = User::factory()->create();

    //     /**
    //      * Only "cliente" is permissed send money
    //      */
    //     $payer->cnpj = null;
    //     $payer->save();

    //     /**
    //      * Payee
    //      *
    //      * @var User $payee
    //      */
    //     $payee = User::factory()->create();

    //     Account::create([
    //         'user_id' => $payer->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     Account::create([
    //         'user_id' => $payee->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     $this
    //     ->actingAs($payer)
    //     ->json('POST', '/financial/transaction/new', [
    //         'type' => 'cpf',
    //         'to' => $payee->cpf,
    //         'amount' => rand(0, 10000000000)
    //     ]);

    //     dd($this->response);

    // }

    // /** @test */
    // public function CreateTransactionWithCNPJ()
    // {
    //     /**
    //      * Payer
    //      *
    //      * @var User $user
    //      */
    //     $payer = User::factory()->create();

    //     /**
    //      * Only "cliente" is permissed send money
    //      */
    //     $payer->cnpj = null;
    //     $payer->save();

    //     /**
    //      * Payee
    //      *
    //      * @var User $user
    //      */
    //     $payee = User::factory()->create();

    //     Account::create([
    //         'user_id' => $payer->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     Account::create([
    //         'user_id' => $payee->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     $this->actingAs($payer)->json('POST', '/financial/transaction/new', [
    //         'type' => 'email',
    //         'to' => $payee->cnpj,
    //         'amount' => rand(0, 10000000000)
    //     ])->assertResponseOk();

    // }

    // /** @test */
    // public function RollbackTransaction()
    // {
    //     /**
    //      * Payer
    //      *
    //      * @var User $user
    //      */
    //     $payer = User::factory()->create();

    //     /**
    //      * Only "cliente" is permissed send money
    //      */
    //     $payer->cnpj = null;
    //     $payer->save();

    //     /**
    //      * Payee
    //      *
    //      * @var User $user
    //      */
    //     $payee = User::factory()->create();

    //     Account::create([
    //         'user_id' => $payer->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     Account::create([
    //         'user_id' => $payee->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     $transaction = new Transaction();

    //     $transaction->payer_account_id = $payer->id;
    //     $transaction->payee_account_id = $payee->id;
    //     $transaction->amount = rand(0, 10000000000);
    //     $transaction->status = 'completa';

    //     $transaction->save();

    //     $this->actingAs($payer)->json('DELETE', '/financial/transaction', [
    //         'id' => $transaction->id
    //     ])->assertResponseOk();
    // }

    // /** @test */
    // public function DeleteAccount()
    // {

    //     /**
    //      * User without financial account
    //      *
    //      * @var User $user
    //      */
    //     $user = User::factory()->create();

    //     Account::create([
    //         'user_id' => $user->id,
    //         'balance_value' => rand(0, 10000000000)
    //     ]);

    //     $this->actingAs($user)->json('DELETE', '/financial')->assertResponseOk();

    // }

}

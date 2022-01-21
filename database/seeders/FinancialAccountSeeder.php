<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Repositories\User\UserInterface;
use App\Repositories\Financial\AccountInterface;

class FinancialAccountSeeder extends Seeder
{

    /**
     * User Repository Interface
     *
     * @var UserInterface
     */
    protected UserInterface $user;

    /**
     * Account Repository Interface
     *
     * @var AccountInterface
     */
    protected AccountInterface $account;

    /**
     * Constructor method
     *
     * @param UserInterface $user
     * @param AccountInterface $account
     */
    public function __construct(UserInterface $user, AccountInterface $account)
    {
        $this->user = $user;
        $this->account = $account;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->user->all();

        collect($users)->map(function ($user) {

            $this->account->create([
                'user_id' => $user->id,
                'balance_value' => rand(0, 10000000000)
            ]);

        });
    }
}

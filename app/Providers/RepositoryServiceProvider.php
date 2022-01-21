<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\User\{UserInterface, UserRepository};

use App\Repositories\Financial\{
    AccountRepository,
    AccountInterface,
    TransactionRepository,
    TransactionInterface
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // User
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );

        // Financial Account
        $this->app->bind(
            AccountInterface::class,
            AccountRepository::class
        );

        // Financial Transaction
        $this->app->bind(
            TransactionInterface::class,
            TransactionRepository::class
        );

    }
}

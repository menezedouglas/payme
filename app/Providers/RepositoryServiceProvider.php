<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\User\{UserInterface, UserRepository};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
    }
}

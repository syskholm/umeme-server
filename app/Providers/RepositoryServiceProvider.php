<?php

namespace App\Providers;

use App\Repositories\AuthInterface;
use App\Repositories\CustomerInterface;
use App\Repositories\UserInterface;
use App\Services\AuthService;
use App\Services\CustomerService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repoBindings = [
        UserInterface::class => UserService::class,
        AuthInterface::class => AuthService::class,
        CustomerInterface::class => CustomerService::class,
    ];

    /**
     * Register services.
     */
    public function register()
    {
        foreach ($this->repoBindings as $interface => $service) {
            $this->app->bind($interface, $service);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}

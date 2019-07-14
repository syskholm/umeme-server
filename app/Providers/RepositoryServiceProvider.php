<?php

namespace App\Providers;

use App\Repositories\CustomerInterface;
use App\Services\CustomerService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repoBindings = [
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

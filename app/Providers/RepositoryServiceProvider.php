<?php

namespace App\Providers;

use App\Repositories\MeetingRepository;
use App\Repositories\RegisterRepository;
use App\Repositories\Interfaces\MeetingRepositoryInterface;
use App\Repositories\Interfaces\RegisterRepositoryInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            RegisterRepositoryInterface::class,
            RegisterRepository::class
        );

        $this->app->bind(
            MeetingRepositoryInterface::class,
            MeetingRepository::class
        );
    }
}

<?php

namespace App\Providers;

use App\Services\Schedule\ScheduleService;
use App\Services\Schedule\ScheduleServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ScheduleServiceInterface::class, ScheduleService::class);
    }
}

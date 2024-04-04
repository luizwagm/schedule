<?php

namespace App\Providers;

use App\Events\CreateScheduleEvent;
use App\Events\CreateUserEvent;
use App\Events\UpdateScheduleEvent;
use App\Events\UpdateUserEvent;
use App\Listeners\CheckAlreadyUseDateListener;
use App\Listeners\CheckIsWeekendsDateListener;
use App\Listeners\CreateScheduleListener;
use App\Listeners\CreateUserListener;
use App\Listeners\UpdateScheduleListener;
use App\Listeners\UpdateUserListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateUserEvent::class => [
            CreateUserListener::class,
        ],
        UpdateUserEvent::class => [
            UpdateUserListener::class,
        ],
        CreateScheduleEvent::class => [
            CheckAlreadyUseDateListener::class,
            CheckIsWeekendsDateListener::class,
            CreateScheduleListener::class
        ],
        UpdateScheduleEvent::class => [
            CheckAlreadyUseDateListener::class,
            CheckIsWeekendsDateListener::class,
            UpdateScheduleListener::class
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }    
}

<?php

namespace App\Listeners;

use App\Events\CreateScheduleEvent;
use App\Repositories\Schedule\ScheduleRepositoryInterface;

class CreateScheduleListener
{
    public function __construct(
        protected ScheduleRepositoryInterface $repository
    ) {}

    public function handle(CreateScheduleEvent $event)
    {
        $this->repository->create($event?->schedule);
    }
}

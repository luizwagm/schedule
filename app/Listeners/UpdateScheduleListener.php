<?php

namespace App\Listeners;

use App\Events\UpdateScheduleEvent;
use App\Repositories\Schedule\ScheduleRepositoryInterface;

class UpdateScheduleListener
{
    public function __construct(
        protected ScheduleRepositoryInterface $repository
    ) {}

    public function handle(UpdateScheduleEvent $event)
    {
        $this->repository->update($event?->schedule, $event?->id);
    }
}

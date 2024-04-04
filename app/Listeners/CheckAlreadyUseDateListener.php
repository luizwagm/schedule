<?php

namespace App\Listeners;

use App\Exceptions\ScheduleCannotCreatedDateAlreadyUseException;
use App\Repositories\Schedule\ScheduleRepositoryInterface;

class CheckAlreadyUseDateListener
{
    public function __construct(
        protected ScheduleRepositoryInterface $repository
    ) {}

    public function handle($event)
    {
        $get = $this->repository->dateAlreadyUse($event?->schedule);

        if ($get) {
            throw new ScheduleCannotCreatedDateAlreadyUseException();

            return false;
        }
    }
}

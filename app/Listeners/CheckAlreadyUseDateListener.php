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
        if (! empty($event?->schedule?->start_date)) {
            $execute = $this->repository->dateAlreadyUse($event?->schedule);
        
            if ($execute) {
                throw new ScheduleCannotCreatedDateAlreadyUseException();

                return false;
            }
        }
    }
}

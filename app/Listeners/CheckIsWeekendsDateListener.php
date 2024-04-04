<?php

namespace App\Listeners;

use App\Exceptions\ScheduleCannotCreatedOnWeekendsException;
use Carbon\Carbon;

class CheckIsWeekendsDateListener
{
    public function handle($event)
    {
        $startDate = new Carbon($event?->schedule?->start_date);
        $endDate = new Carbon($event?->schedule?->end_date);

        if ($startDate->isWeekend()) {
            throw new ScheduleCannotCreatedOnWeekendsException('Not create date on weekends');

            return false;
        }

        if ($endDate->isWeekend()) {
            throw new ScheduleCannotCreatedOnWeekendsException('Not concluded date on weekends');

            return false;
        }
    }
}

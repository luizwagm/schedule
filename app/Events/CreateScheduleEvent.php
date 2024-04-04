<?php

namespace App\Events;

use App\Http\Requests\Schedule\ScheduleRequest;
use Illuminate\Foundation\Events\Dispatchable;

class CreateScheduleEvent
{
    use Dispatchable;

    public function __construct(
        public ScheduleRequest $schedule
    ) {}
}

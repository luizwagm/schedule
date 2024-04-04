<?php

namespace App\Events;

use App\Http\Requests\Schedule\ScheduleRequest;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateScheduleEvent
{
    use Dispatchable;

    public function __construct(
        public ScheduleRequest $schedule,
        public int $id
    ) {}
}

<?php

namespace App\Events;

use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateScheduleEvent
{
    use Dispatchable;

    public function __construct(
        public ScheduleUpdateRequest $schedule,
        public int $id
    ) {}
}

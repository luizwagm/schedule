<?php

namespace App\Services\Schedule;

use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleServiceInterface
{
    public function get(int $id): Schedule;
    public function notifications(int $id): Collection;
    public function getLatestSchedule(): Schedule;
    public function delete(int $id): void;
    public function all(): Collection;
    public function filter(ScheduleFilterRequest $request): Collection;
}
